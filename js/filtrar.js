document.querySelectorAll('input[name="filtro"]').forEach(radio => {
    radio.addEventListener('change', function () {
        const selectedValue = this.value.toLowerCase();
        const tableVisible = document.getElementById('tabla-monitor');
        const tableOculta = document.getElementById('tabla-oculta');

        width = window.innerWidth;

        console.log(width);

        const table = tableOculta.getElementsByTagName('tbody')[0];
        const rows = table.getElementsByTagName('tr');

        for (let i = 0; i < rows.length; i++) {
            const tipo = rows[i].getElementsByTagName('td')[1].innerText.trim().toLowerCase();

            if (selectedValue === 'todos' || tipo === selectedValue) {
                rows[i].style.display = '';
            } else {
                rows[i].style.display = 'none';
            }
        }

    });
});

document.querySelectorAll('input[name="filtro"]').forEach(radio => {
    radio.addEventListener('change', function () {
        const selectedValue = this.value.toLowerCase();
        const cards = document.querySelectorAll('.card-movil');


        cards.forEach(card => {
            const tipoElement = card.querySelector('.buscar-card:nth-child(2)');
            const tipo = tipoElement ? tipoElement.textContent.trim().toLowerCase() : '';

            if (selectedValue === 'mostrar10') {
                card.style.display = 'grid';

            } else if (selectedValue === 'todos') {
                // Mostrar todas las tarjetas
                card.style.display = 'grid';

            } else if (tipo === selectedValue) {
                // Mostrar las tarjetas que coinciden con el tipo seleccionado
                card.style.display = 'grid';
            } else {
                // Ocultar las tarjetas que no coinciden
                card.style.display = 'none';
            }
        });
    });
});







