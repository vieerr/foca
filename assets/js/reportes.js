$(document).ready(async function () {
  const setList = (data) => {
    const tbody = $("#report-table");
    tbody.empty();
    data.reverse().map((item) => {
      const row = `
        <tr class="text-center">
            <td class="px-6 py-4 border-b border-gray-200">${
              item.id_registro
            }</td>
            <td class="px-6 py-4 border-b border-gray-200">${
              item.nombre_categoria
            }</td>
            <td class="px-6 py-4 border-b border-gray-200">$ ${
              item.valor_registro
            }</td>
            <td class="px-6 py-4 border-b border-gray-200">${
              item.metodo_registro
            }</td>
            <td class="px-6 py-4 border-b border-gray-200">${
              item.fecha_accion
            }</td>
            <td class="px-6 py-4 border-b border-gray-200">${
              item.fecha_registro
            }</td>
            <td class="px-6 py-4 border-b border-gray-200">
                <span class="badge ${
                  item.estado_registro === "activo"
                    ? "badge-success"
                    : "badge-error"
                } badge-outline">
                    ${item.estado_registro}
                </span>
            </td>
            <td class="py-3">
                <div class="inline-flex">
                    <button class="edit-income btn btn-sm btn-info" data-id="${
                      item.id_registro
                    }">
                        <i class="fas fa-pencil"></i>
                        <p class="hidden lg:inline-block">Editar</p>
                    </button>
                    <button data-id="${
                      item.id_registro
                    }" class="btn btn-sm btn-error ml-2 toggle-status">
                        <i class="fas fa-retweet"></i>
                        <p class="hidden lg:inline-block">Anular</p>
                    </button>
                    <button class="btn btn-sm btn-warning ml-2">
                        <i class="fas fa-qrcode"></i>
                        <p class="hidden lg:inline-block">QR</p>
                    </button>
                </div>
            </td>
        </tr>
        `;
      tbody.append(row); // Append the row to the tbody
    });
  };

  const handleFilter = (id, field, array) => {
    console.log(array);
    $(`#${id}`).change(() => {
      const selected = $(`#${id}`).val();
      if (selected.length === 0) {
        setList(array);
        return;
      }
      setList(array.filter((inc) => inc[field] === selected));
    });
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

  handleFilter("report-type", "tipo_registro", regs);

  // Export to PDF button
  $(".btn-primary").on("click", () => exportToPDF(regs));

  // Export to CSV button
  $(".btn-secondary").on("click", () => exportToCSV(regs));
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
