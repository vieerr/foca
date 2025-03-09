$(document).ready(async function () {
  const filterByDateRange = (data, startDate, endDate) => {
    return data.filter((item) => {
      const itemDate = new Date(item.fecha_accion);
      return itemDate >= startDate && itemDate <= endDate;
    });
  };

  const filterBySearch = (data, searchTerm) => {
    if (searchTerm) {
      return data.filter((item) =>
        Object.values(item).some((value) =>
          String(value).toLowerCase().includes(searchTerm)
        )
      );
    }
    return data; // Return the original data if no search term is provided
  };

  const setList = (data) => {
    const tbody = $("#report-table");
    tbody.empty();
    data.reverse().map((item) => {
      const row = `
        <tr class="hover">
          <td><span class="badge ${
            item.tipo_registro === "ingreso" ? "badge-success" : "badge-error"
          }">${item.tipo_registro}</span></td>
          <td>${item.fecha_accion}</td>
          <td>${item.nombre_categoria}</td>
          <td class="${
            item.tipo_registro === "ingreso" ? "text-success" : "text-error"
          }">${item.valor_registro}</td>
          <td>${item.metodo_registro}</td>
          <td><span class="badge ${
            item.estado_registro === "activo" ? "badge-success" : "badge-error"
          }">${item.estado_registro}</span></td>
        </tr>
      `;
      tbody.append(row); // Append the row to the tbody
    });
  };

  const applyFilters = () => {
    const selectedType = $("#report-type").val();
    const initial = $("#fecha-inicial").val();
    const final = $("#fecha-final").val();
    const searchTerm = $("#search-bar").val().trim();

    let filteredData = regs;

    // Apply date range filter
    if (initial.length > 0 && final.length > 0) {
      const startDate = new Date(initial);
      const endDate = new Date(final);
      if (!!!startDate || !!!endDate || startDate > endDate) {
        console.log("Invalid date range");
        return;
      }
      filteredData = filterByDateRange(filteredData, startDate, endDate);
    }

    // Apply report type filter
    if (selectedType.length > 0) {
      filteredData = filteredData.filter(
        (inc) => inc.tipo_registro === selectedType
      );
    }

    // Apply search filter
    if (searchTerm.length > 0) {
      filteredData = filterBySearch(filteredData, searchTerm);
    }

    filteredRegs = filteredData;
    setList(filteredData);
  };

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
    }
  };

  const regs = await fetchRegs();
  let filteredRegs = regs;
  setList(regs);

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

  // Initialize Summary Chart (Bar Chart)
  const summaryCtx = $("#summaryChart")[0].getContext("2d");
  new Chart(summaryCtx, {
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

  // Initialize Category Chart (Pie Chart)
  // const categoryCtx = $("#categoryChart")[0].getContext("2d");
  // new Chart(categoryCtx, {
  //   type: "pie",
  //   data: {
  //     labels: ["Comida", "Transporte", "Servicios", "Entretenimiento"],
  //     datasets: [
  //       {
  //         data: [45, 25, 20, 10],
  //         backgroundColor: ["#36D399", "#3B82F6", "#FBBF24", "#F472B6"],
  //       },
  //     ],
  //   },
  // });

  // Event listeners for filters
  $("#report-type, #fecha-inicial, #fecha-final, #search-bar").on(
    "change input",
    function () {
      applyFilters();
    }
  );

  // Quick filters
  $(".btn.btn-xs").on("click", function () {
    const filterType = $(this).text().trim();
    let startDate, endDate;

    switch (filterType) {
      case "Este Mes":
        startDate = new Date(
          new Date().getFullYear(),
          new Date().getMonth(),
          1
        );
        endDate = new Date(
          new Date().getFullYear(),
          new Date().getMonth() + 1,
          0
        );
        break;
      case "Últimos 7 días":
        endDate = new Date();
        startDate = new Date(endDate);
        startDate.setDate(endDate.getDate() - 7);
        break;
      case "Trimestre Actual":
        const currentQuarter = Math.floor((new Date().getMonth() + 3) / 3);
        startDate = new Date(
          new Date().getFullYear(),
          (currentQuarter - 1) * 3,
          1
        );
        endDate = new Date(new Date().getFullYear(), currentQuarter * 3, 0);
        break;
      default:
        startDate = null;
        endDate = null;
    }

    if (startDate && endDate) {
      $("#fecha-inicial").val(startDate.toISOString().split("T")[0]);
      $("#fecha-final").val(endDate.toISOString().split("T")[0]);
      applyFilters();
    }
  });

  // Export to PDF button
  $(".btn-primary").on("click", () => exportToPDF(filteredRegs));

  // Export to CSV button
  $(".btn-secondary").on("click", () => exportToCSV(filteredRegs));
});

function exportToPDF(regs) {
  const { jsPDF } = window.jspdf;
  const body = [];
  const head = Object.keys(regs[0]);

  regs.map((reg) => {
    body.push(Object.values(reg));
  });

  const doc = new jsPDF(
    {
      orientation: "landscape",
      unit: "pt",
      format: "a4",
    },
    { putOnlyUsedFonts: true, floatPrecision: 16 }
  );
  autoTable(doc, {
    head: [head],
    body: body,
  });
  doc.save("reporte.pdf");
}

function exportToCSV(regs) {
  const body = [];
  const head = Object.keys(regs[0]);

  regs.map((reg) => {
    body.push(Object.values(reg));
  });

  const data = [head, ...body];
  const csv = Papa.unparse(data);

  const blob = new Blob([csv], { type: "text/csv;charset=utf-8;" });
  const link = document.createElement("a");
  const url = URL.createObjectURL(blob);
  link.setAttribute("href", url);
  link.setAttribute("download", "report.csv");
  link.style.visibility = "hidden";
  document.body.appendChild(link);
  link.click();
  document.body.removeChild(link);
}
