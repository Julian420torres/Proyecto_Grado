/*!
    * Start Bootstrap - SB Admin v7.0.5 (https://startbootstrap.com/template/sb-admin)
    * Copyright 2013-2022 Start Bootstrap
    * Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-sb-admin/blob/master/LICENSE)
    */
    // 
// Scripts
// 


window.addEventListener('DOMContentLoaded', event => {

    // Toggle the side navigation
    const sidebarToggle = document.body.querySelector('#sidebarToggle');
    if (sidebarToggle) {
        // Uncomment Below to persist sidebar toggle between refreshes
        // if (localStorage.getItem('sb|sidebar-toggle') === 'true') {
        //     document.body.classList.toggle('sb-sidenav-toggled');
        // }
        sidebarToggle.addEventListener('click', event => {
            event.preventDefault();
            document.body.classList.toggle('sb-sidenav-toggled');
            localStorage.setItem('sb|sidebar-toggle', document.body.classList.contains('sb-sidenav-toggled'));
        });
    }

});

document.addEventListener("DOMContentLoaded", function () {
    const botonAgregar = document.getElementById("btn_agregar");
    
    if (botonAgregar) {
        if (typeof agregarProducto === "function") {
            botonAgregar.addEventListener("click", agregarProducto);
            console.log("✅ Botón 'Agregar' encontrado y evento asignado.");
        } else {
            console.warn("⚠️ La función agregarProducto no está definida aún.");
        }
    } else {
        console.log("❌ No se encontró el botón 'Agregar'");
    }
});
