// Eliminar solicitud
(function () {
    const botonesEliminar = document.querySelectorAll('.eliminar');

    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', mostrarFormulario);
    });

    function mostrarFormulario(event) {
        const idSolicitud = event.target.closest('.eliminar').value; // Obtener el ID de la solicitud
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
            <form class="formulario-solicitud" method="POST" >

            <div class="titulo-iconos">
                <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#EA3323" class="iconos">
                    <path d="M280-120q-33 0-56.5-23.5T200-200v-520h-40v-80h200v-40h240v40h200v80h-40v520q0 33-23.5 56.5T680-120H280Zm400-600H280v520h400v-520ZM360-280h80v-360h-80v360Zm160 0h80v-360h-80v360ZM280-720v520-520Z" />
                </svg>
                <h1> ¿Estás seguro de eliminar esta solicitud?</h1>
            </div>

                
                <div class="campos">
                    <p>Esta acción no se puede deshacer y la solicitud será eliminada permanentemente.</p>
                </div>
                <div class="opciones">
                    <input type="hidden" name="id" value="${idSolicitud}" />
                    <input id="submit" class="boton boton-submit" type="submit" value="Eliminar" />
                    <button class="boton cerrar-modal" type="button">Cancelar</button>
                </div>
            </form>
        `;

        setTimeout(() => {
            const formulario = document.querySelector('.formulario-solicitud');
            formulario.classList.add('animar');
        }, 0);

        //Sabemos a que elemento le estamos dando click
        modal.addEventListener('click', function (e) {
           

            if (e.target.classList.contains('cerrar-modal')) {
                const formulario = document.querySelector('.formulario-solicitud');
                formulario.classList.add('cerrar');
                setTimeout(() => {
                    modal.remove();
                }, 500);
            }
            if (e.target.classList.contains('boton-submit')) {
                submitGenerarSolicitud();
            }

        })
        document.querySelector('body').appendChild(modal);
    }

    
    //Comprobar que los campos no se encuentren vacios
    function submitGenerarSolicitud(){

        const selectedRadio = document.querySelector('input[name="tipo"]:checked');
        
        const descripcion= document.querySelector('#descripcion').value.trim();

        const lugar = document.querySelector('#lugar').value.trim();

        if (!selectedRadio || descripcion === '' || lugar === '') {
            document.getElementById('submit').type = 'button';
            mostrarAlerta('Todos los campos son obligatorios', 'error',document.querySelector('.formulario-solicitud h1'));
            return;
        }

        if (selectedRadio && descripcion && lugar) {
            document.getElementById('submit').type = 'submit';
        }

        //Muestra un mensaje de alerta en la interfaz
        function mostrarAlerta(mensaje, tipo, referencia){//referencia nos dice donde se va crear la alerta
            // Previene la creacion de multiples alertas 
            const alertPrevia = document.querySelector('.alerta');

            if(alertPrevia){
                alertPrevia.remove();
            }

            const alerta = document.createElement('DIV');
            alerta.classList.add('alerta',tipo);
            alerta.textContent = mensaje;

            referencia.appendChild(alerta);


            //Eliminar Alerta
            setTimeout(() => {
                alerta.remove();
            }, 5000);
        }
    }



})();
