$(document).ready(async () => {
  const itemsPerPage = 10; // Number of items per page
  let currentPage = 1; // Current page
  let allData = []; // Store all data for filtering and pagination

  const generateInsertModal = () => {
    $("#id-display").remove();
    $("#expense-form-title").html("Registrar nuevo ingreso");
    $("#expense-form-btn").html("Agregar");
    $("#edit-expense-form").attr("id", "register-expense-form");
    $("#register-expense-form").trigger("reset");
  };

  const generateEditModal = (expenseId) => {
    $("#expense-form-title").html("Editar ingreso");
    $("#expense-form-btn").html("Actualizar");
    $("#register-expense-form").attr("id", "edit-expense-form");

    if ($("#id-display").length) {
      $("#id_registro").val(expenseId);
    } else {
      $("#edit-expense-form").prepend(`
        <label id="id-display" class="input min-w-full" for="id_registro">
          <span class="label font-bold">ID</span>
          <input type="text" name="id_registro" id="id_registro" readonly value="${expenseId}">
        </label>`);
    }

    $.ajax({
      url: `router.php?route=get-one-reg`,
      method: "POST",
      data: { id_registro: expenseId },
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

  const handleAuth = (perms) => {
    if (admin) return;
    if (!perms.includes(2)) $("#register-expense-btn").addClass("btn-disabled");
    if (!perms.includes(6))
      $(".toggle-status-expense").addClass("btn-disabled");
    if (!perms.includes(12)) $(".edit-expense").addClass("btn-disabled");
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
        url: "router.php?route=get-all-expense-categories",
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

  const fetchExpense = async () => {
    try {
      const response = await $.ajax({
        url: "router.php?route=get-all-expense",
        method: "GET",
        dataType: "json",
      });
      return response;
    } catch (error) {
      console.error("Error al obtener los regs:", error);
    }
  };

  const populateRegs = (regs, cats) => {
    const catMap = new Map(cats.map((cat) => [cat.id_categoria, cat]));
    return regs.map((ing) => ({
      ...ing,
      ...catMap.get(ing.id_categoria),
    }));
  };

  const setList = (data) => {
    const tbody = $("#gastos-table-body");
    tbody.empty();
    data.map((item) => {
      const row = `
        <tr class="text-center">
            <td class="px-6 py-4 border-b border-gray-200">${item.id_registro
        }</td>
            <td class="px-6 py-4 border-b border-gray-200">${item.nombre_registro
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
                    <button class="edit-expense btn btn-sm btn-info" data-id="${
                      item.id_registro
                    }">
                        <i class="fas fa-pencil text-white"></i>
                        <p class="hidden lg:inline-block text-white">Editar</p>
                    </button>
                    <button data-id="${
                      item.id_registro
                    }" data-status="${item.estado_registro}" class="btn btn-sm btn-error ml-2 toggle-status-expense">
                        <i class="fas fa-retweet text-white"></i>
                        <p class="hidden lg:inline-block text-white">
                          ${item.estado_registro === "activo" ? 
                            "Anular" : "Activar"
                          }
                        </p>
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
    const newRegs = await fetchExpense();
    allData = populateRegs(newRegs, cats);
    const filteredData = applyFilters(allData);
    displayPage(filteredData, currentPage);
    updatePagination(filteredData);
  };

  const cats = await fetchCategories();
  setCategories(cats);

  const regs = await fetchExpense();
  allData = populateRegs(regs, cats);
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

  $("#register-expense-btn").click(function () {
    generateInsertModal();
    modalGasto.showModal();
  });

  // Toggle status handler - Prevención de múltiples clicks
  $(document).off("click", ".toggle-status-expense").on("click", ".toggle-status-expense", function (event) {
    event.stopPropagation();
    const expenseId = $(this).data("id");
    const currentStatus = $(this).data("status") === "activo" ? true : false;
    const nextStatus = !currentStatus;
    const statusMsg = nextStatus ? "activar" : "anular";
    const newStatus = nextStatus ? "activo" : "anulado";

    const data = `id_registro=${expenseId}&estado_registro=${newStatus}`;

    if (confirm(`¿Estás seguro que deseas ${statusMsg} este gasto?`)) {
      $.ajax({
        url: "router.php?route=edit-reg",
        type: "PUT",
        data: data,
        success: (response) => {
          refetchList();
          console.log("Update successful:", response);
        },
        error: (xhr, status, error) => {
          console.error("Error updating:", error);
        }
      });
    }
  });

  // Edit form handler - Prevención de múltiples submits
  $(document).off("submit", "#edit-expense-form").on("submit", "#edit-expense-form", (e) => {
    e.preventDefault();
    const $btn = $("#expense-form-btn").prop("disabled", true);
    const formData = $("#edit-expense-form").serialize();

    $.ajax({
      url: "router.php?route=edit-reg",
      type: "PUT",
      data: formData,
      success: (response) => {
        $("#close-modal").trigger("submit");
        refetchList();
        $("#edit-expense-form").trigger("reset");
        console.log("Update successful:", response);
      },
      error: (xhr, status, error) => {
        console.error("Error updating:", error);
      },
      complete: () => $btn.prop("disabled", false)
    });
  });

  // Edit button handler - Control de apertura única
  let editModalOpen = false;
  $(document).off("click", ".edit-expense").on("click", ".edit-expense", function () {
    if (!editModalOpen) {
      editModalOpen = true;
      const expenseId = $(this).data("id");
      generateEditModal(expenseId);
      modalGasto.showModal();

      // Resetear estado al cerrar modal
      modalGasto.on('close', () => editModalOpen = false);
    }
  });

  // Register form handler - Prevención de submits múltiples
  $(document).off("submit", "#register-expense-form").on("submit", "#register-expense-form", (e) => {
    e.preventDefault();
    const $btn = $("#expense-form-btn").prop("disabled", true);
    const formData = $("#register-expense-form").serialize();

    $.ajax({
      url: "router.php?route=create-expense",
      type: "POST",
      data: formData,
      success: (response) => {
        $("#close-modal").trigger("submit");
        refetchList();
        $("#register-expense-form").trigger("reset");
        console.log("Register successful:", response);
      },
      error: (xhr, status, error) => {
        console.error("Error creating:", error);
      },
      complete: () => $btn.prop("disabled", false)
    });
  });
  
  handleAuth(perms);
});
