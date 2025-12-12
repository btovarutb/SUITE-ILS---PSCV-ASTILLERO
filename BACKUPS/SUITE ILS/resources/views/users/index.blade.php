<x-app-layout>
    <div class="container mx-auto px-4 py-8 sm:px-20">
        <div class="px-2 sm:px-4">
            @section('title', 'Gestión de Usuarios y Permisos')
            <div class="w-3/4 mx-auto">
                <h1 class="text-2xl font-bold mb-4" style="font-family: 'Inter', sans-serif;">Gestión de Usuarios y Permisos</h1>
                @foreach ($roles as $role)
                    <div x-data="{ open: localStorage.getItem('open{{ $role->id }}') === 'true' }" class="mb-2">
                        <button @click="open = !open; localStorage.setItem('open{{ $role->id }}', open)" class="w-full bg-blue-900 text-white px-4 py-2 rounded flex justify-between items-center mx-auto">
                            {{ $role->name }}
                            <span x-show="!open" class="ml-2">▼</span>
                            <span x-show="open" class="ml-2">▲</span>
                        </button>
                        <div x-show="open" x-collapse class="bg-white border border-blue-900 mt-2 rounded w-full mx-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('users.index', ['sort_field' => 'name', 'sort_order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
                                                Nombre
                                                @if($sortField === 'name')
                                                    @if($sortOrder === 'asc')
                                                        ▲
                                                    @else
                                                        ▼
                                                    @endif
                                                @endif
                                            </a>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            <a href="{{ route('users.index', ['sort_field' => 'email', 'sort_order' => $sortOrder === 'asc' ? 'desc' : 'asc']) }}">
                                                Email
                                                @if($sortField === 'email')
                                                    @if($sortOrder === 'asc')
                                                        ▲
                                                    @else
                                                        ▼
                                                    @endif
                                                @endif
                                            </a>
                                        </th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider"></th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($role->users as $user)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->name }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">{{ $user->email }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <a href="{{ route('users.edit', $user->id) }}" class="text-blue-500 hover:text-blue-700">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
</x-app-layout>
