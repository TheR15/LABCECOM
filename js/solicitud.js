
//Generar una nueva solicitud
(function () {
    const editar = document.querySelector('#solicitud')
    editar.addEventListener('click', mostrarFormulario);

    function mostrarFormulario() {
        const modal = document.createElement('DIV');
        modal.classList.add('modal');
        modal.innerHTML = `
        
        <form class="formulario-solicitud"  method="POST" action="solicitudes.php">

        <div class="titulo-iconos">
            <svg class = "iconos solicitud"xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#0000F5"><path d="M319.33-246.67h321.34v-66.66H319.33v66.66Zm0-166.66h321.34V-480H319.33v66.67ZM226.67-80q-27 0-46.84-19.83Q160-119.67 160-146.67v-666.66q0-27 19.83-46.84Q199.67-880 226.67-880H574l226 226v507.33q0 27-19.83 46.84Q760.33-80 733.33-80H226.67Zm314-542.67v-190.66h-314v666.66h506.66v-476H540.67Zm-314-190.66v190.66-190.66 666.66-666.66Z"/></svg>
               <h1 >Generar solicitud de mantenimiento</h1>

        </div>
               <div class="campos">

                <h2>Nombre del solicitante</h2>
                <input id="nombre" class="input campos" type="text" name="nombre"  placeholder= "Ingrese el nombre del solicitante" >

                <h2>Tipo de solicitud</h2>
                <div class="radios"> 
                    <h2><input class="rad" type="radio" name="tipo" value="Preventivo">Preventivo</h2>
                    <h2><input class="rad" type="radio" name="tipo" value="Correctivo">Correctivo</h2>
                </div>

                <h2>Descripcion</h2>
                <input id="descripcion" class="input campos" type="text" name="descripcion"  placeholder= "Ingrese una breve descripcion del problema" >

                <h2>Lugar</h2>
                <input id="lugar" class="input campos" type="text" name="lugar" placeholder = "Ingrese el lugar del equipo">

               </div>
                <div class="opciones">  
                
                <input id="submit" class="boton boton-submit" type="submit" value="Generar"/>
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

        const nombre = document.querySelector('#nombre').value.trim();

        if (!selectedRadio || descripcion === '' || lugar === '' || nombre === '') {
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
