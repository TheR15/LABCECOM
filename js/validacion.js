const referencia = document.querySelector('#referencia');
const formulario = document.querySelector('.formulario');

formulario.addEventListener('submit', function(evento) {
    const nombre = document.querySelector('#nombre').value;
    const email = document.querySelector('#email').value;
    const contrasena = document.querySelector('#contrasena').value;
    const contrasena2 = document.querySelector('#contrasena2').value;

    function validacionCrearCuenta() {
        let errores = false;

        if (contrasena !== contrasena2) {
            mostrarAlerta('Las contraseñas no son iguales', 'error', referencia);
            errores = true;
        }

        if (contrasena.length <= 6) {
            mostrarAlerta('La contraseña debe de contener al menos 6 caracteres', 'error', referencia);
            errores = true;
        }

        if (!nombre || !email || !contrasena) {
            mostrarAlerta('Todos los campos son obligatorios', 'error', referencia);
            errores = true;
        }

        return !errores;
    }

    function mostrarAlerta(mensaje, tipo, referencia) {
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
        }, 3000);
    }

    if (!validacionCrearCuenta()) {
        evento.preventDefault();
    }

});