document.getElementById('buscar').addEventListener('keyup', function () {
    let input = this.value.trim().toLowerCase();
    let table = document.getElementById('tabla-oculta');
    let trs = table.getElementsByTagName('tr');


    for (let i = 1; i < trs.length; i++) { // Empezar en 1 para saltar el encabezado
        let tds = trs[i].getElementsByTagName('td');
        let found = false;

        for (let j = 0; j < tds.length; j++) {
            if (tds[j].textContent.toLowerCase().includes(input)) {
                found = true;
                break;
            }
        }

        trs[i].style.display = found ? '' : 'none';
    }

});

document.getElementById('buscar').addEventListener('keyup', function () {
    let input = this.value.trim().toLowerCase();
    let cards = document.querySelectorAll('.card-movil');

    cards.forEach(function (card) {
        let labels = card.querySelectorAll('.buscar-card');
        let found = false;

        labels.forEach(function (label) {
            if (label.textContent.toLowerCase().includes(input)) {
                found = true;
            }
        });

        card.style.display = found ? 'grid' : 'none';
    });
});
