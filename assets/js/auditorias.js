$(document).ready(async () => {
  const itemsPerPage = 10;
  let currentPage = 1;
  let allData = [];

  const fetchAudits = async () => {
    try {
      const response = await $.ajax({
        url: "router.php?route=get-all-audits",
        method: "GET",
        dataType: "json",
      });

      return response;
    } catch (error) {
      console.error("Error al obtener los regs:", error);
    }
  };

  const setList = (data) => {
    const tbody = $("#auditorias-table-body");
    tbody.empty();
    data.map((item) => {
      const row = `
          <tr class="text-center">
              <td class="px-6 py-4 border-b border-gray-200">${
                item.id_auditoria
              }</td>
              <td class="px-6 py-4 border-b border-gray-200">${item.accion}</td>
              <td class="px-6 py-4 border-b border-gray-200">${
                item.tabla_afectada
              }</td>
              <td class="px-6 py-4 border-b border-gray-200">${
                item.id_usuario
              }</td>
              <td class="px-6 py-4 border-b border-gray-200">${
                item.fecha_hora
              }</td>
              <td class="px-6 py-4 border-b border-gray-200">${
                item.detalles ?? ""
              }</td>
          </tr>
          `;
      tbody.append(row);
    });
  };

  const handleFilter = (id, field, array) => {
    $(`#${id}`).change(() => {
      const selected = $(`#${id}`).val();
      if (selected.length === 0) {
        setList(array);
        displayPage(array, currentPage);
        updatePagination(array);
        return;
      }
      const filtered = array.filter(
        (inc) => inc[field].toLowerCase() === selected.toLowerCase()
      );
      setList(filtered);
      displayPage(filtered, currentPage);
      updatePagination(filtered);
    });
  };

  const refetchList = async () => {
    const res = await fetchAudits();
    allData = res.reverse();
    updatePagination(allData);
    displayPage(allData, currentPage);
    return res;
  };

  const displayPage = (data, page) => {
    const startIndex = (page - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const paginatedData = data.slice(startIndex, endIndex);
    setList(paginatedData);
  };

  const updatePagination = (data) => {
    const totalPages = Math.ceil(data.length / itemsPerPage);
    const pagination = $(".btn-group");
    pagination.empty();

    pagination.append(`<button class="btn btn-sm" id="prev-page">«</button>`);

    for (let i = 1; i <= totalPages; i++) {
      pagination.append(
        `<button class="btn btn-sm ${
          i === currentPage ? "btn-active" : ""
        }" data-page="${i}">${i}</button>`
      );
    }

    pagination.append(`<button class="btn btn-sm" id="next-page">»</button>`);

    // Handle page navigation
    $(".btn-group button").click(function () {
      const page = $(this).data("page");
      if (page) {
        currentPage = page;
        displayPage(data, currentPage);
        updatePagination(data);
      } else if ($(this).attr("id") === "prev-page" && currentPage > 1) {
        currentPage--;
        displayPage(data, currentPage);
        updatePagination(data);
      } else if (
        $(this).attr("id") === "next-page" &&
        currentPage < totalPages
      ) {
        currentPage++;
        displayPage(data, currentPage);
        updatePagination(data);
      }
    });
  };

  const res = await refetchList();

  handleFilter("filtro_accion", "accion", res);
  handleFilter("filtro_apartado", "tabla_afectada", res);
  handleFilter("filtro_usuario", "id_usuario", res);

  $("#filtro_ano").append(
    [...new Set(res.map((item) => new Date(item.fecha_hora).getFullYear()))]
      .map((year) => `<option value="${year}">${year}</option>`)
      .join("")
  );

  $("#filtro_mes").append(
    [
      ...new Set(
        res.map((item) =>
          new Date(item.fecha_hora).toLocaleString("default", { month: "long" })
        )
      ),
    ]
      .map((month) => `<option value="${month}">${month}</option>`)
      .join("")
  );

  $("#filtro_ano, #filtro_mes").change(function () {
    const selectedYear = $("#filtro_ano").val();
    const selectedMonth = $("#filtro_mes").val();

    if (selectedYear.length === 0 && selectedMonth.length === 0) {
      setList(allData);
      displayPage(allData, currentPage);
      updatePagination(allData);
      return;
    }

    const filteredData = allData.filter((item) => {
      const itemDate = new Date(item.fecha_hora);
      return (
        (!selectedYear || itemDate.getFullYear() == selectedYear) &&
        (!selectedMonth ||
          itemDate.toLocaleString("default", { month: "long" }) ===
            selectedMonth)
      );
    });
    setList(filteredData);
    displayPage(filteredData, currentPage);
    updatePagination(filteredData);
    return;
  });
});
