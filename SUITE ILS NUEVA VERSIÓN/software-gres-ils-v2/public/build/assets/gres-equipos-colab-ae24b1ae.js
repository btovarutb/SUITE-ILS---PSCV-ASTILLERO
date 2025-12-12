document.addEventListener("DOMContentLoaded",function(){const o=document.getElementById("manage-equipos-colab-btn");o&&o.addEventListener("click",()=>{l(window.buqueId)})});function l(o){fetch(`/gres/equipos/colaboradores/${o}`).then(t=>{if(!t.ok)throw new Error("Error al cargar colaboradores");return t.json()}).then(t=>{const e=t.colaboradores||[],r=m(e);Swal.fire({title:"Gestionar Colaboradores de Equipos",html:r,width:"800px",showCancelButton:!1,showConfirmButton:!1,didOpen:()=>{E(o)}})}).catch(t=>{console.error("Error al cargar colaboradores:",t),Swal.fire("Error","No se pudo cargar la lista de colaboradores.","error")})}function m(o){return`
        <div>
            <button id="add-equipo-colab-btn" class="bg-green-500 text-white px-4 py-2 rounded mb-4">Añadir Nuevo Colaborador</button>
            <table class="table-auto w-full border-collapse">
                <thead>
                    <tr class="bg-gray-200">
                        <th class="border px-4 py-2">Cargo</th>
                        <th class="border px-4 py-2">Nombre</th>
                        <th class="border px-4 py-2">Apellido</th>
                        <th class="border px-4 py-2">Entidad</th>
                        <th class="border px-4 py-2">Acciones</th>
                    </tr>
                </thead>
                <tbody id="equipos-colab-table-body">
                    ${o.map(e=>`
        <tr>
            <td class="border px-4 py-2">${e.cargo}</td>
            <td class="border px-4 py-2">${e.nombre}</td>
            <td class="border px-4 py-2">${e.apellido}</td>
            <td class="border px-4 py-2">${e.entidad}</td>
            <td class="border px-4 py-2 text-center">
                <button class="edit-equipo-colab-btn bg-blue-500 text-white px-3 py-1 rounded" data-id="${e.id}">Editar</button>
                <button class="delete-equipo-colab-btn bg-red-500 text-white px-3 py-1 rounded" data-id="${e.id}">Eliminar</button>
            </td>
        </tr>
    `).join("")}
                </tbody>
            </table>
        </div>
    `}function E(o){const t=document.getElementById("add-equipo-colab-btn"),e=document.getElementById("equipos-colab-table-body");t&&t.addEventListener("click",()=>{i(o,null)}),e.querySelectorAll(".edit-equipo-colab-btn").forEach(r=>{r.addEventListener("click",()=>{const a=r.getAttribute("data-id");i(o,a)})}),e.querySelectorAll(".delete-equipo-colab-btn").forEach(r=>{r.addEventListener("click",()=>{const a=r.getAttribute("data-id");g(a,o)})})}function i(o,t){const e=t!==null;(e?fetch(`/gres/equipos/colaboradores/${o}/${t}`).then(a=>a.json()):Promise.resolve({})).then(a=>{const{cargo:c="",nombre:s="",apellido:u="",entidad:b=""}=a;Swal.fire({title:e?"Editar Colaborador":"Añadir Nuevo Colaborador",html:`
                <div class="space-y-4">
                    <input type="text" id="colab-cargo" placeholder="Cargo" value="${c}" class="swal2-input">
                    <input type="text" id="colab-nombre" placeholder="Nombre" value="${s}" class="swal2-input">
                    <input type="text" id="colab-apellido" placeholder="Apellido" value="${u}" class="swal2-input">
                    <input type="text" id="colab-entidad" placeholder="Entidad" value="${b}" class="swal2-input">
                </div>
            `,confirmButtonText:e?"Guardar Cambios":"Añadir Colaborador",preConfirm:()=>({cargo:document.getElementById("colab-cargo").value,nombre:document.getElementById("colab-nombre").value,apellido:document.getElementById("colab-apellido").value,entidad:document.getElementById("colab-entidad").value})}).then(n=>{if(n.isConfirmed){const p=e?`/gres/equipos/colaboradores/${t}`:"/gres/equipos/colaboradores";fetch(p,{method:e?"PUT":"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")},body:JSON.stringify({buque_id:o,...n.value})}).then(d=>d.ok?d.json():d.json().then(h=>{throw new Error(h.message||"Error desconocido al guardar colaborador.")})).then(d=>{Swal.fire("Éxito",e?"Colaborador actualizado correctamente.":"Colaborador añadido correctamente.","success"),l(o)}).catch(d=>{console.error("Error al guardar colaborador:",d),Swal.fire("Error","No se pudo guardar el colaborador.","error")})}})})}function g(o,t){Swal.fire({title:"¿Eliminar Colaborador?",text:"Esta acción no se puede deshacer.",icon:"warning",showCancelButton:!0,confirmButtonText:"Eliminar",cancelButtonText:"Cancelar"}).then(e=>{e.isConfirmed&&fetch(`/gres/equipos/colaboradores/${o}`,{method:"DELETE",headers:{"X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")}}).then(r=>{if(!r.ok)throw new Error("Error al eliminar el colaborador");l(t)}).catch(()=>{Swal.fire("Error","No se pudo eliminar el colaborador.","error")})})}
