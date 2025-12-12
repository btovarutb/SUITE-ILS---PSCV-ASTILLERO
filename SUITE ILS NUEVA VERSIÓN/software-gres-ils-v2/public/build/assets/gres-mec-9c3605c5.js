document.addEventListener("DOMContentLoaded",function(){const o=document.getElementById("manage-colaboradores-btn");o&&o.addEventListener("click",()=>{c(window.buqueId)})});function c(o){fetch(`/gres/colaboradores/${o}`).then(r=>{if(!r.ok)throw new Error("Error al cargar colaboradores");return r.json()}).then(r=>{const e=r.colaboradores||[],a=h(e);Swal.fire({title:"Gestionar Colaboradores",html:a,width:"800px",showCancelButton:!1,showConfirmButton:!1,didOpen:()=>{f(o)}})}).catch(r=>{console.error("Error al cargar colaboradores:",r),Swal.fire("Error","No se pudo cargar la lista de colaboradores.","error")})}function h(o){return`
        <div>
            <button id="add-colab-btn" class="bg-green-500 text-white px-4 py-2 rounded mb-4">Añadir Nuevo Colaborador</button>
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
                <tbody id="colaboradores-table-body">
                    ${o.map(e=>`
        <tr>
            <td class="border px-4 py-2">${e.cargo}</td>
            <td class="border px-4 py-2">${e.nombre}</td>
            <td class="border px-4 py-2">${e.apellido}</td>
            <td class="border px-4 py-2">${e.entidad}</td>
            <td class="border px-4 py-2 text-center">
                <button class="edit-colab-btn bg-blue-500 text-white px-3 py-1 rounded" data-id="${e.id}">Editar</button>
                <button class="delete-colab-btn bg-red-500 text-white px-3 py-1 rounded" data-id="${e.id}">Eliminar</button>
            </td>
        </tr>
    `).join("")}
                </tbody>
            </table>
        </div>
    `}function f(o){const r=document.getElementById("add-colab-btn"),e=document.getElementById("colaboradores-table-body");r&&r.addEventListener("click",()=>{b(o,null)}),e.querySelectorAll(".edit-colab-btn").forEach(a=>{a.addEventListener("click",()=>{const n=a.getAttribute("data-id");b(o,n)})}),e.querySelectorAll(".delete-colab-btn").forEach(a=>{a.addEventListener("click",()=>{const n=a.getAttribute("data-id");g(n,o)})})}function b(o,r){const e=r!==null;(e?fetch(`/gres/colaboradores/${o}/${r}`).then(n=>n.json()):Promise.resolve({})).then(n=>{const{cargo:s="",nombre:t="",apellido:d="",entidad:u=""}=n;Swal.fire({title:e?"Editar Colaborador":"Añadir Nuevo Colaborador",html:`
                <div class="space-y-4">
                    <input type="text" id="colab-cargo" placeholder="Cargo" value="${s}" class="swal2-input">
                    <input type="text" id="colab-nombre" placeholder="Nombre" value="${t}" class="swal2-input">
                    <input type="text" id="colab-apellido" placeholder="Apellido" value="${d}" class="swal2-input">
                    <input type="text" id="colab-entidad" placeholder="Entidad" value="${u}" class="swal2-input">
                </div>
            `,confirmButtonText:e?"Guardar Cambios":"Añadir Colaborador",preConfirm:()=>({cargo:document.getElementById("colab-cargo").value,nombre:document.getElementById("colab-nombre").value,apellido:document.getElementById("colab-apellido").value,entidad:document.getElementById("colab-entidad").value})}).then(i=>{if(i.isConfirmed){const p=e?`/gres/colaboradores/${r}`:"/gres/colaboradores";fetch(p,{method:e?"PUT":"POST",headers:{"Content-Type":"application/json","X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")},body:JSON.stringify({buque_id:o,...i.value})}).then(l=>l.ok?l.json():l.json().then(m=>{throw new Error(m.message||"Error desconocido al guardar colaborador.")})).then(l=>{Swal.fire("Éxito",e?"Colaborador actualizado correctamente.":"Colaborador añadido correctamente.","success"),c(o)}).catch(l=>{console.error("Error al guardar colaborador:",l),Swal.fire("Error","No se pudo guardar el colaborador.","error")})}})})}function g(o,r){Swal.fire({title:"¿Eliminar Colaborador?",text:"Esta acción no se puede deshacer.",icon:"warning",showCancelButton:!0,confirmButtonText:"Eliminar",cancelButtonText:"Cancelar"}).then(e=>{e.isConfirmed&&fetch(`/gres/colaboradores/${o}`,{method:"DELETE",headers:{"X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")}}).then(a=>{if(!a.ok)throw new Error("Error al eliminar el colaborador");c(r)}).catch(()=>{Swal.fire("Error","No se pudo eliminar el colaborador.","error")})})}document.addEventListener("DOMContentLoaded",function(){const o=document.getElementById("export-pdf-btn");o&&o.addEventListener("click",()=>{y(window.buqueId)})});function y(o){const r=["Acoplando Sistemas","Insertando diagramas correspondientes","Insertando MEC por Sistemas","Añadiendo Observaciones escritas por el usuario"];let e=0,a;const n=document.createElement("div");n.innerHTML=`
        <div class="loading-container">
            <div id="loading-message"
                 style="opacity: 0;
                        transition: opacity 0.5s, transform 0.5s;
                        transform: translateX(-20px);
                        margin-top: 10px;">
            </div>
        </div>
    `;function s(){const t=document.getElementById("loading-message");t&&(t.style.opacity="0",t.style.transform="translateX(20px)",setTimeout(()=>{t.textContent=r[e],t.style.transform="translateX(-20px)",t.offsetHeight,t.style.opacity="1",t.style.transform="translateX(0)",e=(e+1)%r.length},500))}Swal.fire({title:"Generando PDF",html:n,didOpen:()=>{Swal.showLoading(),s(),a=setInterval(s,1e4)},willClose:()=>{clearInterval(a)},allowOutsideClick:!1}),fetch(`/gres/colaboradores/${o}`).then(t=>{if(!t.ok)throw new Error(`Error al obtener colaboradores: ${t.status}`);return t.json()}).then(t=>{const d=new FormData;return d.append("colaboradores",JSON.stringify(t.colaboradores)),d.append("buque_id",o),fetch("/gres/export-pdf",{method:"POST",headers:{"X-CSRF-TOKEN":document.querySelector('meta[name="csrf-token"]').getAttribute("content")},body:d})}).then(t=>{if(!t.ok)throw new Error("Error al generar el PDF");return t.blob()}).then(t=>{Swal.close();const d=URL.createObjectURL(t);window.open(d,"_blank")}).catch(t=>{console.error("Error:",t),Swal.fire({icon:"error",title:"Error",text:t.message})})}
