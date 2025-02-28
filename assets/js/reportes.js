$(document).ready(function () {
  // Initialize Summary Chart (Bar Chart)
  const summaryCtx = $("#summaryChart")[0].getContext("2d");
  new Chart(summaryCtx, {
    type: "bar",
    data: {
      labels: ["Ene", "Feb", "Mar", "Abr", "May", "Jun"],
      datasets: [
        {
          label: "Ingresos",
          data: [6500, 5900, 8000, 8100, 5600, 5500],
          backgroundColor: "#36D399",
        },
        {
          label: "Gastos",
          data: [2800, 3700, 2400, 3000, 4200, 3100],
          backgroundColor: "#F87272",
        },
      ],
    },
  });

  // Initialize Category Chart (Pie Chart)
  const categoryCtx = $("#categoryChart")[0].getContext("2d");
  new Chart(categoryCtx, {
    type: "pie",
    data: {
      labels: ["Comida", "Transporte", "Servicios", "Entretenimiento"],
      datasets: [
        {
          data: [45, 25, 20, 10],
          backgroundColor: ["#36D399", "#3B82F6", "#FBBF24", "#F472B6"],
        },
      ],
    },
  });
});
