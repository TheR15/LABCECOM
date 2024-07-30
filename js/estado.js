// Eliminar solicitud
(function () {
    const botonesEliminar = document.querySelectorAll('.estado');

    botonesEliminar.forEach(boton => {
        boton.addEventListener('click', mostrarFormulario);
    });

    function mostrarFormulario(event) {
        const idSolicitud = event.target.closest('.estado').value; // Obtener el ID de la solicitud
        console.log (idSolicitud);
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
            <form class="formulario-solicitud" method="POST">
                <div class="titulo-iconos">
                    <svg class = 'iconos estado' xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#07a628"><path d="M382-240 154-468l57-57 171 171 367-367 57 57-424 424Z"/></svg>
                    <h1> ¿Deseas confirmar la solicitud?</h1>
                </div>
                <div class="opciones">
                    <input type="hidden" name="accion" value="${idSolicitud}" />
                    <input id="submit" class="boton boton-submit" type="submit" value="Confirmar" />
                    <button class="boton cerrar-modal" type="button">Cancelar</button>
                </div>
            </form>
        `;

        document.body.appendChild(modal);

        setTimeout(() => {
            const formulario = document.querySelector('.formulario-solicitud');
            formulario.classList.add('animar');
        }, 0);

        modal.addEventListener('click', function (e) {
            if (e.target.classList.contains('cerrar-modal')) {
                const formulario = document.querySelector('.formulario-solicitud');
                formulario.classList.add('cerrar');
                setTimeout(() => {
                    modal.remove();
                }, 500);
            }
        });
    }



})();
