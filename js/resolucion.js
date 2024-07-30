function checkResolution() {
    const tableVisible = document.getElementById('tabla-monitor');
    const tableOculta = document.getElementById('tabla-oculta');
    const input = document.getElementById('buscar');
    const pag = document.getElementById("pag");
    let width = window.innerWidth;
    if (width <= 768) {
        // Ocultar tabla visible y oculta
        tableVisible.style.display = 'none';
        tableOculta.style.display = 'none';
        pag.style.display = 'none';
        
    } else {
        // Restaurar el estado anterior
        pag.style.display = 'flex';
        tableVisible.style.display = 'none';
        tableOculta.style.display = 'inline-table';
        // Solo mostrar tabla oculta si se está filtrando
        if (document.querySelector('input[name="filtro"]:checked').value.toLowerCase() === 'mostrar10') {
            if (input.value === '') {
                tableVisible.style.display = 'inline-table';
                tableOculta.style.display = 'none';

            } else {
                tableVisible.style.display = 'none';
                tableOculta.style.display = 'inline-table';
                pag.style.display = 'none';
            }
        } if (document.querySelector('input[name="filtro"]:checked').value.toLowerCase() === 'correctivo') {
            tableOculta.style.display = 'inline-table';
            tableVisible.style.display = 'none';
            pag.style.display = 'none';
        } if (document.querySelector('input[name="filtro"]:checked').value.toLowerCase() === 'preventivo') {
            tableOculta.style.display = 'inline-table';
            tableVisible.style.display = 'none';
            pag.style.display = 'none';
        } if (document.querySelector('input[name="filtro"]:checked').value.toLowerCase() === 'todos') {
            tableOculta.style.display = 'inline-table';
            tableVisible.style.display = 'none';
            pag.style.display = 'none';
        }
    }
}

// Ejecutar checkResolution cada 500 milisegundos
setInterval(checkResolution, 10);

// También puedes llamar a la función una vez al cargar la página
checkResolution();



/*
function checkResolution() {
    
    const tableVisible = document.getElementById('tabla-monitor');
    const tableOculta = document.getElementById('tabla-oculta');

    width = window.innerWidth;
    console.log (width);
    if (width <= 868) {
        // Mostrar tabla visible y ocultar tabla oculta
        tableVisible.style.display = 'none';
        tableOculta.style.display = 'none';
        document.getElementById("pag").style.display = "none";
    }

    width = window.innerWidth;
    console.log(width);
}
setInterval(checkResolution, 500);
// También puedes llamar a la función una vez al cargar la página
checkResolution();

*/