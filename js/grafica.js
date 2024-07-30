const ctx = document.getElementById('chart-general');

$totalUsuarios = datosDesdePHP.totalUsuarios;
$totalSolicitudes = datosDesdePHP.totalSolicitudes;

new Chart(ctx, {
  type: 'doughnut',
  data: {
    labels: ['Usuarios', 'Solicitudes', 'Consultas', 'Impresiones'],
    datasets: [{
      label: 'Total',
      data: [$totalUsuarios, $totalSolicitudes, 5, 5],
      backgroundColor: [
        '#0b57d0',
        '#f4d03f',
        '#27ae60',
        '#d35400'
      ],
      borderWidth: 1.5,
      borderRadius: 10,
    }]
  },
  options: {
    plugins: {
      legend: {
        display: true,
        position: 'bottom', // Posiciona la leyenda debajo de la gráfica
        labels: {
          padding: 20, // Espacio adicional entre la leyenda y la gráfica
        },
      }
    },
    layout: {
      padding: {
        left: 20,
        right: 20,
        top: 20,
        bottom: 20
      }
    }
  },
});


//Grafica de lineas
const ctx2 = document.getElementById('chart-barras-fechas');

var fechasFormateadas = fechas.map(fechaString => {
  var fechaObj = new Date(fechaString);
  if (isNaN(fechaObj)) {
      console.error("Fecha inválida:", fechaString);
      return fechaString; // Devolver la cadena original o manejar el error
  }
  var opciones = { month: 'long', day: 'numeric' };
  return fechaObj.toLocaleDateString('es-MX', opciones);
});

console.log(fechasFormateadas);
console.log(conteos);


new Chart(ctx2, {
  type: 'line',
  data: {
      labels: fechasFormateadas, // Fechas como etiquetas en el eje X
      datasets: [{
          label: 'Número de Solicitudes',
          data: conteos, // Conteo de solicitudes en cada fecha
          backgroundColor: 'rgba(11, 87, 208, 0.2)',
          borderColor: '#0b57d0',
          borderWidth: 1.5,
          tension: 0.3 // Suaviza la línea si se trata de un gráfico lineal
      }]
  },
  options: {
      plugins: {
          title: {
              padding: {
                  top: 10,
                  bottom: 20
              }
          },
          legend: {
            display:false,
          }
      },
      scales: {
          y: {
              beginAtZero: false, // Comienza en el valor mínimo de los datos
              min: 0.5, // Asegura que el gráfico comience en 1
              suggestedMin: 0.5, // Sugiere que el mínimo sea 1
          }
      },
      layout: {
          padding: {
              left: 20,
              right: 20,
              top: 20,
              bottom: 20
          }
      }
  },
});
