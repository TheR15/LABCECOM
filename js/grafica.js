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

const ctx2 = document.getElementById('chart-barras-fechas');

// Formatear fechas para la gráfica
const fechasFormateadas = fechas.map(fechaString => {
  const fechaObj = new Date(fechaString);
  if (isNaN(fechaObj)) {
    console.error("Fecha inválida:", fechaString);
    return fechaString;
  }
  const opciones = { month: 'long', day: 'numeric' };
  return fechaObj.toLocaleDateString('es-MX', opciones);
});

const filtroGrafica = document.getElementById('filtro-grafica');
filtroGrafica.addEventListener('change', function () {
  const valorFecha = filtroGrafica.value;

  // Verificar si la opción seleccionada es "todas"
  if (valorFecha === 'todas') {
    // Mostrar todas las fechas y conteos
    actualizarGrafica(fechasFormateadas, conteos);
    return; // Terminar la función aquí para no aplicar más filtros
  }

  // Obtener la fecha actual
  const fechaActual = new Date();
  let fechaLimite;

  // Determinar el rango de fecha según la opción seleccionada
  if (valorFecha === '12meses') {
    fechaLimite = new Date(fechaActual);
    fechaLimite.setFullYear(fechaLimite.getFullYear() - 1);
  } else if (valorFecha === '6meses') {
    fechaLimite = new Date(fechaActual);
    fechaLimite.setMonth(fechaLimite.getMonth() - 6);
  } else if (valorFecha === '30dias') {
    fechaLimite = new Date(fechaActual);
    fechaLimite.setDate(fechaLimite.getDate() - 30);
  } else if (valorFecha === '7dias') {
    fechaLimite = new Date(fechaActual);
    fechaLimite.setDate(fechaLimite.getDate() - 7);
  }

  // Filtrar las fechas y los conteos que caen dentro del rango seleccionado
  const fechasFiltradas = [];
  const conteosFiltrados = [];

  fechas.forEach((fecha, index) => {
    const fechaObj = new Date(fecha);
    if (fechaObj >= fechaLimite) {
      fechasFiltradas.push(fechasFormateadas[index]);
      conteosFiltrados.push(conteos[index]);
    }
  });

  // Actualizar la gráfica con los datos filtrados
  actualizarGrafica(fechasFiltradas, conteosFiltrados);
});

function actualizarGrafica(fechas, conteos) {
  // Destruir la gráfica existente si es necesario
  if (window.miGrafica) {
    window.miGrafica.destroy();
  }

  // Crear una nueva gráfica con los datos filtrados
  window.miGrafica = new Chart(ctx2, {
    type: 'line',
    data: {
      labels: fechas,
      datasets: [{
        label: 'Número de Solicitudes',
        data: conteos,
        backgroundColor: 'rgba(11, 87, 208, 0.2)',
        borderColor: '#0b57d0',
        borderWidth: 1.5,
        tension: 0.3
      }]
    },
    options: {
      plugins: {
        title: {
          display: true,
          text: 'Solicitudes por Día',
          color: '#000',
          font: {
            size: 20,
          },
          align: 'center',
          padding: {
            top: 10,
            bottom: 20
          }
        },
        legend: {
          display: false,
        }
      },
      scales: {
        y: {
          beginAtZero: false,
          min: 0.5,
          suggestedMin: 0.5,
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
}

// Inicializar la gráfica con todos los datos
actualizarGrafica(fechasFormateadas, conteos);
