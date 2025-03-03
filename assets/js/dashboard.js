$(document).ready(async () => {
  const fetchRegs = async () => {
    try {
      const response = await $.ajax({
        url: "router.php?route=get-all-regs-with-cats",
        method: "GET",
        dataType: "json",
      });
      return response;
    } catch (error) {
      console.error("Error al obtener los regs:", error);
      // throw error;
    }
  };

  const fetchCats = async () => {
    try {
      const response = await $.ajax({
        url: "router.php?route=get-all-categories",
        method: "GET",
        dataType: "json",
      });
      return response;
    } catch (error) {
      console.error("Error al obtener las categorias:", error);
      // throw error;
    }
  };
  const regs = await fetchRegs();
  // dashboard elements

  let income = [];
  let expense = [];

  regs.map((reg) => {
    reg.tipo_registro === "ingreso" ? income.push(reg) : expense.push(reg);
  });

  $("#income-num").text(income.length);
  $("#expense-num").text(expense.length);
  const expTotal = expense.reduce(
    (prev, curr) => prev + Number(curr.valor_registro),
    0
  );
  $("#expense-total").text(
    `$ ${expense
      .reduce((prev, curr) => prev + Number(curr.valor_registro), 0)
      .toFixed(2)}`
  );
  $("#income-total").text(
    `$ ${income
      .reduce((prev, curr) => prev + Number(curr.valor_registro), 0)
      .toFixed(2)}`
  );

  const monthlyIncome = new Array(12).fill(0);
  const monthlyExpense = new Array(12).fill(0);

  regs.forEach((reg) => {
    const month = new Date(reg.fecha_registro).getMonth(); // Get month index (0-11)
    if (reg.tipo_registro === "ingreso") {
      monthlyIncome[month] += Number(reg.valor_registro);
    } else {
      monthlyExpense[month] += Number(reg.valor_registro);
    }
  });

  const incomeExpensesCtx = $("#incomeExpensesChart")[0].getContext("2d");
  new Chart(incomeExpensesCtx, {
    type: "bar",
    data: {
      labels: [
        "Ene",
        "Feb",
        "Mar",
        "Abr",
        "May",
        "Jun",
        "Jul",
        "Ago",
        "Sep",
        "Oct",
        "Nov",
        "Dic",
      ],
      datasets: [
        {
          label: "Ingresos",
          data: monthlyIncome,
          backgroundColor: "#36D399",
        },
        {
          label: "Gastos",
          data: monthlyExpense,
          backgroundColor: "#F87272",
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
    },
  });

  const categories = await fetchCats();

  const incomeCats = categories.filter(
    (cat) => cat.tipo_categoria === "ingreso"
  );
  const expenseCats = categories.filter(
    (cat) => cat.tipo_categoria === "egreso"
  );

  console.log(incomeCats);
  console.log(expenseCats);
  console.log(regs);

  const getCategoryTotals = (regs) => {
    const names = Array.from(new Set(regs.map((reg) => reg.nombre_categoria)));
    // const unique = new Set(names);
    const values = new Array(names.length).fill(0);
    const obj = Object.fromEntries(
      names.map((key, index) => [key, values[index]])
    );
    regs.map((reg) => {
      obj[reg.nombre_categoria]++;
    });
    return obj;
  };

  const incObj = getCategoryTotals(income);
  const expObj = getCategoryTotals(expense);
  const incomeLabels = Object.keys(incObj);
  const incomeData = Object.values(incObj);

  const expenseLabels = Object.keys(expObj);
  const expenseData = Object.values(expObj);

  // Income Category Breakdown Chart (Pie Chart)
  const incomeCat = $("#income-category")[0].getContext("2d");

  new Chart(incomeCat, {
    type: "pie",
    data: {
      labels: incomeLabels,
      datasets: [
        {
          data: incomeData,
          backgroundColor: [
            "#36D399",
            "#3B82F6",
            "#FBBF24",
            "#F472B6",
            "#A78BFA",
            "#60A5FA",
            "#FCD34D",
            "#F87171",
          ], // Add more colors if needed
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: "bottom",
        },
      },
    },
  });

  // Expense Category Breakdown Chart (Pie Chart)
  const expenseCat = $("#expense-category")[0].getContext("2d");
  new Chart(expenseCat, {
    type: "pie",
    data: {
      labels: expenseLabels,
      datasets: [
        {
          data: expenseData,
          backgroundColor: [
            "#36D399",
            "#3B82F6",
            "#FBBF24",
            "#F472B6",
            "#A78BFA",
            "#60A5FA",
            "#FCD34D",
            "#F87171",
          ], // Add more colors if needed
        },
      ],
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: {
        legend: {
          position: "bottom",
        },
      },
    },
  });

  const populateTable = (data) => {
    const tbody = $("#recent-regs");
    tbody.empty();
    data.forEach((item) => {
      const row = `
            <tr>
                <td><span class="badge ${
                  item.tipo_registro === "ingreso"
                    ? "badge-success"
                    : "badge-error"
                }">${item.tipo_registro}</span></td>
                <td>${item.nombre_registro}</td>
                <td class="${
                  item.tipo_registro === "ingreso"
                    ? "text-success"
                    : "text-error"
                }">${item.valor_registro}</td>
                <td>${item.fecha_accion}</td>
                <td><span class="badge badge-success">${
                  item.estado_registro
                }</span></td>
            </tr>
        `;
      tbody.append(row); // Append the row to the tbody
    });
  };

  populateTable(regs.slice(0, 10));

  // Display Current Date
  const now = new Date();
  const options = { year: "numeric", month: "long", day: "numeric" };
  $("#now-date").text(now.toLocaleDateString("es-ES", options));
});
