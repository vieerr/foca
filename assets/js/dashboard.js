$(document).ready(function () {
  const incomeExpensesCtx = $("#incomeExpensesChart")[0].getContext("2d");
  new Chart(incomeExpensesCtx, {
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
    options: {
      responsive: true,
      maintainAspectRatio: false,
    },
  });

  // Category Breakdown Chart (Pie Chart)
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
    options: {
      responsive: true,
      maintainAspectRatio: false,
    },
  });

  // Display Current Date
  const now = new Date();
  const options = { year: "numeric", month: "long", day: "numeric" };
  $("#now-date").text(now.toLocaleDateString("es-ES", options));
});
