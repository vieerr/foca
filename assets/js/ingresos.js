$(document).ready(async () => {
  const handleAuth = (perms) => {
    console.log(admin);
    if (admin) {
      return;
    }
    if (!perms.includes(3)) {
      $("#register-income-btn").addClass("btn-disabled");
    }
    if (!perms.includes(7)) {
      $(".toggle-status").addClass("btn-disabled");
    }
    if (!perms.includes(13)) {
      $(".edit-income").addClass("btn-disabled");
    }
  };

  const filterByDateRange = (data, startDate, endDate) => {
    return data.filter((item) => {
      const itemDate = new Date(item.fecha_accion);
      return itemDate >= startDate && itemDate <= endDate;
    });
  };

  const fetchCategories = async () => {
    try {
      const response = await $.ajax({
        url: "router.php?route=get-all-income-categories",
        method: "GET",
        dataType: "json",
      });
      return response;
    } catch (error) {
      console.error("Error al obtener las categorias:", error);
    }
  };

  const setCategories = (cats) => {
    const modalCategories = $("#nombre_categoria");
    const filterCategories = $("#filtro_nombre_categoria");
    modalCategories.append(
      '<option value="">Seleccione una categoría</option>'
    );
    filterCategories.append(
      '<option value="">Seleccione una categoría</option>'
    );
    cats.map((cat) => {
      modalCategories.append(
        `<option value=${cat.id_categoria}>${cat.nombre_categoria}</option>`
      );
      filterCategories.append(
        `<option value=${cat.id_categoria}>${cat.nombre_categoria}</option>`
      );
    });
  };

  const fetchIngresos = async () => {
    try {
      const response = await $.ajax({
        url: "router.php?route=get-all-income",
        method: "GET",
        dataType: "json",
      });
      return response;
    } catch (error) {
      console.error("Error al obtener los regs:", error);
    }
  };

  const populateIngresosCats = (ingresos, cats) => {
    const catMap = new Map(cats.map((cat) => [cat.id_categoria, cat]));
    const populated = ingresos.map((ing) => {
      const cat = catMap.get(ing.id_categoria);
      return {
        ...ing,
        ...cat,
      };
    });
    return populated;
  };

  const setList = (data) => {
    const tbody = $("#ingresos-table-body");
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
                <span class="${
                  item.estado_registro === "activo"
                    ? "text-success"
                    : "text-error"
                }">
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
                    <button data-categoria="${
                      item.nombre_categoria
                    }" onclick="qr_modal.showModal()" class="btn btn-sm btn-warning ml-2 qr-btn">
                        <i class="fas fa-qrcode"></i>
                        <p class="hidden lg:inline-block">QR</p>
                    </button>
                </div>
            </td>
        </tr>
        `;
      tbody.append(row);
    });
  };

  const applyFilters = (data) => {
    let filteredData = [...data];

    const searchTerm = $("#search-bar").val().toLowerCase();
    if (searchTerm) {
      filteredData = filteredData.filter((item) =>
        Object.values(item).some((value) =>
          String(value).toLowerCase().includes(searchTerm)
        )
      );
    }

    const selectedCategory = $("#filtro_nombre_categoria").val();
    if (selectedCategory) {
      filteredData = filteredData.filter(
        (item) => item.id_categoria === selectedCategory
      );
    }

    const selectedMethod = $("#filtro_metodo_registro").val();
    if (selectedMethod) {
      filteredData = filteredData.filter(
        (item) => item.metodo_registro === selectedMethod
      );
    }

    const selectedStatus = $("#filtro_estado_registro").val();
    if (selectedStatus) {
      filteredData = filteredData.filter(
        (item) => item.estado_registro === selectedStatus
      );
    }

    const startDate = new Date($("#fecha-inicial").val());
    const endDate = new Date($("#fecha-final").val());
    if (startDate && endDate && startDate <= endDate) {
      filteredData = filterByDateRange(filteredData, startDate, endDate);
    }

    return filteredData;
  };

  const refetchList = async () => {
    const newIncome = await fetchIngresos();
    populatedIncome = populateIngresosCats(newIncome, cats);
    setList(applyFilters(populatedIncome));
  };

  const cats = await fetchCategories();
  setCategories(cats);

  const income = await fetchIngresos();
  let populatedIncome = populateIngresosCats(income, cats);
  setList(populatedIncome);

  $(
    "#search-bar, #filtro_nombre_categoria, #filtro_metodo_registro, #filtro_estado_registro, #fecha-inicial, #fecha-final"
  ).on("input change", () => {
    setList(applyFilters(populatedIncome));
  });

  $(document).on("click", ".qr-btn", function () {
    const categoria = $(this).data("categoria");
    $("#qr-img").attr("src", `assets/qrs/${categoria.split(" ").join("")}.png`);
    $("#qr-title").html(`Categoría: ${categoria}`);
  });

  $("#register-income-btn").click(function () {
    generateInsertModal();
    modalIngreso.showModal();
  });

  $(document).on("click", ".toggle-status", function () {
    const incomeId = $(this).data("id");
    const data = `id_registro=${incomeId}&estado_registro=anulado`;

    if (confirm("¿Estás seguro que deseas anular este registro?")) {
      $.ajax({
        url: "router.php?route=edit-reg",
        type: "PUT",
        data: data,
        success: function (response) {
          refetchList();
          console.log("Update successful:", response);
        },
        error: function (xhr, status, error) {
          console.error("Error updating:", error);
        },
      });
    }
  });

  $(document).on("submit", "#edit-income-form", (e) => {
    e.preventDefault();
    const formData = $("#edit-income-form").serialize();
    $.ajax({
      url: "router.php?route=edit-reg",
      type: "PUT",
      data: formData,
      success: function (response) {
        $("#close-modal").trigger("submit");
        refetchList();
        $("#edit-income-form").trigger("reset");
        console.log("Update successful:", response);
      },
      error: function (xhr, status, error) {
        console.error("Error updating:", error);
      },
    });
  });

  handleAuth(perms);
});
