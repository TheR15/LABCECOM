(function () {
    const botonesEditar = document.querySelectorAll('.editar');

    botonesEditar.forEach(boton => {
        boton.addEventListener('click', mostrarFormulario);
    });

    function mostrarFormulario(event) {
        const valores = event.target.closest('.editar').value.split(',');

        const idSolicitud = valores[0];
        console.log (idSolicitud);
        const tipo = valores[1];
        console.log (tipo);
        const descripcion = valores[2];
        console.log (descripcion);
        const lugar = valores[3];
        console.log (lugar);
        let checkedPreven = '';
        let checkedCorrect = '';

        if (tipo === 'Preventivo') {
            checkedPreven = 'checked';
        }

        if (tipo === 'Correctivo') {
            checkedCorrect = 'checked';
        }

        const modal = document.createElement('div');
        modal.classList.add('modal');
        modal.innerHTML = `
            <form class="formulario-solicitud" method="POST" action="solicitudes.php">
                <div class="titulo-iconos">
                    <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#0b57d0" class="iconos solicitud">
                        <path d="M200-200h57l391-391-57-57-391 391v57Zm-80 80v-170l528-527q12-11 26.5-17t30.5-6q16 0 31 6t26 18l55 56q12 11 17.5 26t5.5 30q0 16-5.5 30.5T817-647L290-120H120Zm640-584-56-56 56 56Zm-141 85-28-29 57 57-29-28Z" />
                    </svg>
                    <h1>Editar solicitud</h1>
                </div>

                <div class="campos">
                    <h2>Tipo de solicitud:</h2>
                    <div class="radios">
                        <h2><input class="rad" type="radio" name="tipo" value="Preventivo" ${checkedPreven}>Preventivo</h2>
                        <h2><input class="rad" type="radio" name="tipo" value="Correctivo" ${checkedCorrect}>Correctivo</h2>
                    </div>

                    <h2>Descripción:</h2>
                    <input id="descripcion" class="input campos" type="text" name="descripcion" placeholder="Ingrese una breve descripcion del problema" value="${descripcion}">

                    <h2>Lugar:</h2>
                    <input id="lugar" class="input campos" type="text" name="lugar" placeholder="Ingrese el lugar del equipo" value="${lugar}">
                </div>

                <div class="opciones">
                    <input type="hidden" name="idEditar" value="${idSolicitud}"/>
                    <input id="submit" class="boton boton-submit" type="submit" value="Actualizar"/>
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

    // Comprobar que los campos no se encuentren vacíos
    function submitGenerarSolicitud() {
        const selectedRadio = document.querySelector('input[name="tipo"]:checked');
        const descripcion = document.querySelector('#descripcion').value.trim();
        const lugar = document.querySelector('#lugar').value.trim();

        if (!selectedRadio || descripcion == '' || lugar == '') {
            document.getElementById('submit').type = 'button';
            mostrarAlerta('Todos los campos son obligatorios', 'error', document.querySelector('.formulario-solicitud h1'));
            return;
        }

        if (selectedRadio && descripcion && lugar) {
            document.getElementById('submit').type = 'submit';
        }

        // Muestra un mensaje de alerta en la interfaz
        function mostrarAlerta(mensaje, tipo, referencia) { // referencia nos dice donde se va crear la alerta
            // Previene la creación de múltiples alertas 
            const alertPrevia = document.querySelector('.alerta');
            if (alertPrevia) {
                alertPrevia.remove();
            }

            const alerta = document.createElement('DIV');
            alerta.classList.add('alerta', tipo);
            alerta.textContent = mensaje;

            referencia.appendChild(alerta);

            // Eliminar Alerta
            setTimeout(() => {
                alerta.remove();
            }, 5000);
        }
    }

})();
