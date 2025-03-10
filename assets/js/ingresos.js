$(document).ready(async () => {
  const itemsPerPage = 10; // Number of items per page
  let currentPage = 1; // Current page
  let allData = []; // Store all data for filtering and pagination

  const handleAuth = (perms) => {
    console.log(admin);
    if (admin) return;
    if (!perms.includes(3)) $("#register-income-btn").addClass("btn-disabled");
    if (!perms.includes(7)) $(".toggle-status-income").addClass("btn-disabled");
    if (!perms.includes(13)) $(".edit-income").addClass("btn-disabled");
  };

  const generateInsertModal = () => {
    $("#id-display").remove();
    $("#income-form-title").html("Registrar nuevo ingreso");
    $("#income-form-btn").html("Agregar");
    $("#edit-income-form").attr("id", "register-income-form");
    $("#register-income-form").trigger("reset");
  };

  const generateEditModal = (incomeId) => {
    $("#income-form-title").html("Editar ingreso");
    $("#income-form-btn").html("Actualizar");
    $("#register-income-form").attr("id", "edit-income-form");

    if ($("#id-display").length) {
      $("#id_registro").val(incomeId);
    } else {
      $("#edit-income-form").prepend(`
        <label id="id-display" class="input min-w-full" for="id_registro">
          <span class="label font-bold">ID</span>
          <input type="text" name="id_registro" id="id_registro" readonly value="${incomeId}">
        </label>`);
    }

    $.ajax({
      url: `router.php?route=get-one-reg`,
      method: "POST",
      data: { id_registro: incomeId },
      success: function (response) {
        const {
          nombre_registro,
          id_categoria,
          valor_registro,
          metodo_registro,
          fecha_accion,
        } = response[0];
        $("#nombre_registro").val(nombre_registro);
        $("#nombre_categoria").val(id_categoria);
        $("#valor_registro").val(valor_registro);
        $("#metodo_registro").val(metodo_registro);
        $("#fecha_accion").val(
          new Date(fecha_accion).toISOString().split("T")[0]
        );
      },
      error: function (xhr, status, error) {
        console.error("Error fetching expense:", error);
      },
    });
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
    return ingresos.map((ing) => ({
      ...ing,
      ...catMap.get(ing.id_categoria),
    }));
  };

  const setList = (data) => {
    const tbody = $("#ingresos-table-body");
    tbody.empty();
    data.map((item) => {
      const row = `
        <tr class="text-center">
            <td class="px-6 py-4 border-b border-gray-200">${item.id_registro
        }</td>
            <td class="px-6 py-4 border-b border-gray-200">${item.nombre_categoria
        }</td>
            <td class="px-6 py-4 border-b border-gray-200">$ ${item.valor_registro
        }</td>
            <td class="px-6 py-4 border-b border-gray-200">${item.metodo_registro
        }</td>
            <td class="px-6 py-4 border-b border-gray-200">${item.fecha_accion
        }</td>
            <td class="px-6 py-4 border-b border-gray-200">${item.fecha_registro
        }</td>
            <td class="px-6 py-4 border-b border-gray-200">

                <span class="${
                  item.estado_registro === "activo"
                    ? "text-[#2db086]"
                    : "text-[#e73f5b]"
                }">
                    ${item.estado_registro}
                </span>
            </td>
            <td class="py-3">
                <div class="inline-flex">

                    <button class="edit-income btn btn-sm btn-info" data-id="${
                      item.id_registro
                    }">
                        <i class="fas fa-pencil text-white"></i>
                        <p class="hidden lg:inline-block text-white">Editar</p>
                    </button>
                    <button data-id="${
                      item.id_registro
                    }" class="btn btn-sm btn-error ml-2 toggle-status-income">
                        <i class="fas fa-retweet text-white"></i>
                        <p class="hidden lg:inline-block text-white">Anular</p>
                    </button>
                    <button data-categoria="${item.nombre_categoria
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

  const displayPage = (data, page) => {
    const startIndex = (page - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const paginatedData = data.reverse().slice(startIndex, endIndex);
    setList(paginatedData);
  };

  const updatePagination = (data) => {
    const totalPages = Math.ceil(data.length / itemsPerPage);
    const pagination = $(".btn-group");
    pagination.empty();

    pagination.append(`<button class="btn btn-sm" id="prev-page">«</button>`);

    for (let i = 1; i <= totalPages; i++) {
      pagination.append(
        `<button class="btn btn-sm ${i === currentPage ? "btn-active" : ""
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

  const refetchList = async () => {
    const newIncome = await fetchIngresos();
    allData = populateIngresosCats(newIncome, cats);
    const filteredData = applyFilters(allData);
    displayPage(filteredData, currentPage);
    updatePagination(filteredData);
  };

  const cats = await fetchCategories();
  setCategories(cats);

  const income = await fetchIngresos();
  allData = populateIngresosCats(income, cats);
  const filteredData = applyFilters(allData);
  displayPage(filteredData, currentPage);
  updatePagination(filteredData);

  $(
    "#search-bar, #filtro_nombre_categoria, #filtro_metodo_registro, #filtro_estado_registro, #fecha-inicial, #fecha-final"
  ).on("input change", () => {
    const filteredData = applyFilters(allData);
    displayPage(filteredData, currentPage);
    updatePagination(filteredData);
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

  // Toggle status handler
  $(document).off("click", ".toggle-status-income").on("click", ".toggle-status-income", function (event) {
    event.stopPropagation();
    const incomeId = $(this).data("id");
    const data = `id_registro=${incomeId}&estado_registro=anulado`;

    if (confirm("¿Estás seguro que deseas anular este registro?")) {
      $.ajax({
        url: "router.php?route=edit-reg",
        type: "PUT",
        data: data,
        success: (response) => {
          refetchList();
          console.log("Actualización exitosa:", response);
        },
        error: (xhr, status, error) => {
          console.error("Error al actualizar:", error);
        }
      });
    }
  });

  // Edit form handler
  $(document).off("submit", "#edit-income-form").on("submit", "#edit-income-form", (e) => {
    e.preventDefault();
    const $btn = $("#income-form-btn").prop("disabled", true);
    const formData = $("#edit-income-form").serialize();

    $.ajax({
      url: "router.php?route=edit-reg",
      type: "PUT",
      data: formData,
      success: (response) => {
        $("#close-modal").trigger("submit");
        refetchList();
        $("#edit-income-form").trigger("reset");
        console.log("Actualización exitosa:", response);
      },
      error: (xhr, status, error) => {
        console.error("Error al actualizar:", error);
      },
      complete: () => $btn.prop("disabled", false)
    });
  });

  // Edit button handler
  let incomeModalOpen = false;
  $(document).off("click", ".edit-income").on("click", ".edit-income", function () {
    if (!incomeModalOpen) {
      incomeModalOpen = true;
      const incomeId = $(this).data("id");
      generateEditModal(incomeId);
      modalIngreso.showModal();

      modalIngreso.on('close', () => incomeModalOpen = false);
    }
  });

  // Register form handler
  $(document).off("submit", "#register-income-form").on("submit", "#register-income-form", (e) => {
    e.preventDefault();
    const $btn = $("#income-form-btn").prop("disabled", true);
    const formData = $("#register-income-form").serialize();

    $.ajax({
      url: "router.php?route=create-income",
      type: "POST",
      data: formData,
      success: (response) => {
        $("#close-modal").trigger("submit");
        refetchList();
        $("#register-income-form").trigger("reset");
        console.log("Registro exitoso:", response);
      },
      error: (xhr, status, error) => {
        console.error("Error al crear:", error);
      },
      complete: () => $btn.prop("disabled", false)
    });
  });

  handleAuth(perms);
});
