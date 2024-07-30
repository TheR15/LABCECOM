(function () {
    const botonMostrar = document.querySelectorAll('.mostrar');

    botonMostrar.forEach(boton => {
        boton.addEventListener('click', mostrarFormulario);
    });

    function mostrarFormulario(event) {
        const valores = event.target.closest('.mostrar').value.split(',');

        const idSolicitud = valores[0];
        const tipo = valores[1];
        const descripcion = valores[2];
        const lugar = valores[3];
        const fecha = valores[4];
        const nombre = valores[5];
        console.log (nombre);

        const fecha0bj = new Date(fecha);
        const mes = fecha0bj.getMonth();
        const dia = fecha0bj.getDate()+1;
        const year = fecha0bj.getFullYear();

        const fechaUTC = new Date(Date.UTC(year,mes,dia));

        console.log (fechaUTC);

        const opciones = { weekday : 'long', year:'numeric', month : 'long', day :'numeric'}
        const fechaFormateada = fechaUTC.toLocaleDateString('es-MX',opciones);

        console.log (fechaFormateada);

        const modal = document.createElement('div');
        modal.classList.add('modal');
        modal.innerHTML = `
            <div class="formulario-solicitud nueva-solicitud">
            <div class="titulo-iconos">
                <svg class="iconos solicitud" xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 0 960 960" width="40px" fill="#27AE60">
                    <path d="M440 680h80V440h-80v240Zm40-320q17 0 28.5-11.5T520 320q0-17-11.5-28.5T480 280q-17 0-28.5 11.5T440 320q0 17 11.5 28.5T480 360Zm0 520q-83 0-156-31.5T197 763q-54-54-85.5-127T80 480q0-83 31.5-156T197 197q54-54 127-85.5T480 80q83 0 156 31.5T763 197q54 54 85.5 127T880 480q0 83-31.5 156T763 763q-54 54-127 85.5T480 880Zm0-80q134 0 227-93t93-227q0-134-93-227t-227-93q-134 0-227 93t-93 227q0 134 93 227t227 93Zm0-320Z"/>
                </svg>
                <h1>Información de la solicitud</h1>
            </div>
                <div class="campos">
                    
                    <h2>Id de solicitud:</h2>
                    <label>${idSolicitud}</label>

                    <h2>Nombre:</h2>
                    <label>${nombre}</label>

                    <h2>Tipo de solicitud:</h2>
                    <div class="radios">
                        <label>${tipo}</label>
                    </div>

                    <h2>Descripción:</h2>
                    <label>${descripcion}</label>

                    <h2>Lugar:</h2>
                    <label>${lugar}</label>

                    <h2>Fecha de solicitud:</h2>
                    <label>${fechaFormateada}</label>
                </div>

                <div class="opciones">
                    <button class="boton cerrar-modal" type="button">Cerrar</button>
                </div>
            </div>
        `;

        document.body.appendChild(modal);

        // Añadir animación después de que se renderice el modal
        setTimeout(() => {
            modal.querySelector('.formulario-solicitud').classList.add('animar');
        }, 0);

        modal.addEventListener('click', function (e) {
            if (e.target.classList.contains('cerrar-modal')) {
                modal.querySelector('.formulario-solicitud').classList.add('cerrar');
                setTimeout(() => {
                    modal.remove();
                }, 500);
            }
        });
    }
    
})();

