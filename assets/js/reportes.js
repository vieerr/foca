$(document).ready(async function () {
  const filterByDateRange = (data, startDate, endDate) => {
    return data.filter((item) => {
      const itemDate = new Date(item.fecha_accion);
      return itemDate >= startDate && itemDate <= endDate;
    });
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

  const handleFilter = (id, field, array) => {
    $(`#${id}`).change(() => {
      applyFilters();
    });
  };

  const applyFilters = () => {
    const selectedType = $("#report-type").val();
    const initial = $("#fecha-inicial").val();
    const final = $("#fecha-final").val();

    let filteredData = regs;

    if (initial.length > 0 && final.length > 0) {
      const startDate = new Date(initial);
      const endDate = new Date(final);
      if (!!!startDate || !!!endDate || startDate > endDate) {
        console.log("Invalid date range");
        return;
      }
      filteredData = filterByDateRange(filteredData, startDate, endDate);
    }

    if (selectedType.length > 0) {
      filteredData = filteredData.filter((inc) => inc.tipo_registro === selectedType);
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
      // throw error;
    }
  };

  const regs = await fetchRegs();
  let filteredRegs = regs;
  setList(regs);

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

  handleFilter("report-type", "tipo_registro", filteredRegs);

  $("#fecha-inicial, #fecha-final").on("input", function () {
    applyFilters();
  });

  // Export to PDF button
  $(".btn-primary").on("click", () => exportToPDF(filteredRegs));

  // Export to CSV button
  $(".btn-secondary").on("click", () => exportToCSV(filteredRegs));
});

function exportToPDF(regs) {
  const { jsPDF } = window.jspdf;
  console.log(window);

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
  // autoTable(doc, { html: ".table" });
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