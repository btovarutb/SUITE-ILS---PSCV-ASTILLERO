<?php

namespace App\Http\Controllers;

use App\Models\Buque;
use App\Models\GresEquipo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Config;

class GresEquipoController extends Controller
{
    public function exportPdf(Request $request)
    {
        try {
            ini_set('memory_limit', '512M');
            set_time_limit(300);

            $validated = $request->validate([
                'buque_id' => 'required|exists:buques,id',
                // 'equipos_catalogo' llega como JSON (opcional)
                // 'colaboradores'    llega como JSON (opcional, igual los consultamos abajo)
            ]);

            $buqueId = (int) $validated['buque_id'];
            $buque   = Buque::find($buqueId);

            if (!$buque) {
                return response()->json(['error' => 'El buque asociado no existe.'], 404);
            }

            $titulo          = "Anexo GRES Equipos:\n{$buque->nombre}";
            $fechaGeneracion = now()->format('d/m/Y');

            // === Colaboradores (los seguimos levantando de BD; si te interesa usar los del form, parsea $request->input('colaboradores'))
            $colaboradores = \App\Models\GresEquipoColab::where('buque_id', $buqueId)
                ->orderBy('cargo')
                ->get();

            // === Logos/portada
            $logoBase64        = $this->fileToBase64(public_path('images/CotecmarLogoPDF.png'), 'image/png');
            $headerLogoBase64  = $this->fileToBase64(public_path('images/CotecmarLogoPDF.png'), 'image/png');
            $portadaBase64     = $this->fileToBase64(public_path('images/PortadaImagen.webp'), 'image/webp');

            // === Catálogo recibido desde la página (id -> {codigo, nombre})
            $catalogo = collect(json_decode($request->input('equipos_catalogo', '[]'), true))
                ->filter(fn($e) => isset($e['id']))
                ->mapWithKeys(function ($e) {
                    $id = (int) Arr::get($e, 'id', 0);
                    return [$id => [
                        'codigo' => trim((string) Arr::get($e, 'codigo', '')),
                        'nombre' => trim((string) Arr::get($e, 'nombre', '')),
                    ]];
                });

            if ($catalogo->isEmpty()) {
                // Fallback: intenta reconstruir desde Flask (como en modGresEquipo)
                try {
                    $resp = Http::get(Config::get('api.flask_url_2') . "/api/equipos-buque?buque_id={$buqueId}");
                    $raw  = $resp->json() ?? [];
                    $catalogo = collect($raw)
                        ->filter(fn($e) => isset($e['id']) || isset($e['id_equipo']))
                        ->mapWithKeys(function ($e) {
                            $arr   = (array)$e;
                            $idLsa = (int)($arr['id'] ?? $arr['id_equipo'] ?? 0);
                            return [$idLsa => [
                                'codigo' => (string) ($arr['cj'] ?? ''),
                                'nombre' => (string) ($arr['nombre_equipo'] ?? 'Sin nombre'),
                            ]];
                        });
                } catch (\Throwable $ex) {
                    Log::error('Fallback Flask falló: ' . $ex->getMessage());
                    $catalogo = collect(); // se quedará vacío y se usará "Sin código/Sin nombre"
                }
            }

            // === GRES de BD (sin traer codigo/nombre)
            $gresRows = GresEquipo::where('buque_id', $buqueId)->get();

            // === Armar arreglo final para la vista del PDF, enriqueciendo con el catálogo
            $equipos = $gresRows->map(function ($r) use ($catalogo) {
                // Observaciones
                $observaciones = is_string($r->observaciones)
                    ? json_decode($r->observaciones, true)
                    : ($r->observaciones ?? []);

                // Diagrama → base64 (detecta mime según extensión)
                $imageBase64 = null;
                if ($r->diagrama) {
                    $path = null;
                    if (Storage::exists('public/' . $r->diagrama)) {
                        $path = Storage::path('public/' . $r->diagrama);
                    } elseif (file_exists(public_path($r->diagrama))) {
                        $path = public_path($r->diagrama);
                    }
                    if ($path && file_exists($path)) {
                        $mime = $this->guessImageMime($path); // 'image/webp', 'image/png', etc.
                        $imageBase64 = $this->fileToBase64($path, $mime);
                    }
                }

                $cat = $catalogo->get((int) $r->equipo_id, []);
                $codigo = trim((string) ($cat['codigo'] ?? ''));
                $nombre = trim((string) ($cat['nombre'] ?? ''));

                return [
                    'codigo'        => 'CJ: ' . ($codigo !== '' ? $codigo : 'Sin código'),
                    'nombre'        => $nombre !== '' ? $nombre : 'Sin nombre',
                    'mec'           => $r->mec ?? 'Sin MEC',
                    'diagrama'      => $imageBase64,
                    'observaciones' => $observaciones,
                ];
            });

            Log::info('Equipos para PDF (con catálogo de la vista):', $equipos->toArray());

            // === Config DomPDF
            $config = [
                'isHtml5ParserEnabled'      => true,
                'isPhpEnabled'              => true,
                'isRemoteEnabled'           => true,
                'defaultFont'               => 'sans-serif',
                'dpi'                       => 96,
                'defaultPaperSize'          => 'letter',
                'defaultPaperOrientation'   => 'portrait',
                'isFontSubsettingEnabled'   => true,
            ];

            $pdf = Pdf::loadView('pdf.gres-equipo-export', compact(
                    'titulo',
                    'equipos',
                    'logoBase64',
                    'headerLogoBase64',
                    'fechaGeneracion',
                    'colaboradores',
                    'portadaBase64'
                ))
                ->setOptions($config)
                ->setPaper('letter', 'portrait');

            return response($pdf->output(), 200, [
                'Content-Type'              => 'application/pdf',
                'Content-Disposition'       => 'inline; filename="anexo-gres-equipos.pdf"',
                'Cache-Control'             => 'public, must-revalidate, max-age=0',
                'Pragma'                    => 'public',
                'X-Content-Type-Options'    => 'nosniff'
            ]);

        } catch (\Throwable $e) {
            Log::error('Error exportPdf GRES equipos:', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'input' => $request->all()
            ]);

            return response()->json([
                'error'   => 'Error generando el PDF',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    // === Helpers privados ===
    private function fileToBase64(?string $path, string $fallbackMime = 'image/png'): ?string
    {
        if (!$path || !file_exists($path)) return null;
        try {
            $mime = $fallbackMime ?: 'image/png';
            if (function_exists('mime_content_type')) {
                $detected = @mime_content_type($path);
                if ($detected && str_starts_with($detected, 'image/')) $mime = $detected;
            }
            $data = file_get_contents($path);
            return 'data:' . $mime . ';base64,' . base64_encode($data);
        } catch (\Throwable $ex) {
            Log::warning("fileToBase64 error ({$path}): " . $ex->getMessage());
            return null;
        }
    }

    private function guessImageMime(string $path): string
    {
        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));
        return match ($ext) {
            'webp' => 'image/webp',
            'jpg', 'jpeg' => 'image/jpeg',
            'gif' => 'image/gif',
            'svg' => 'image/svg+xml',
            default => 'image/png',
        };
    }
}
