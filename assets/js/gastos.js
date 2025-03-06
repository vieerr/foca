$(document).ready(async () => {

  const handleAuth = (perms) => {
    console.log(admin);
    if(admin)
    {
      return;
    }
    if (!perms.includes(2)) {
      $("#register-expense-btn").addClass("btn-disabled");
    }
    if (!perms.includes(6)) {
      $(".toggle-status").addClass("btn-disabled");
    }
    if (!perms.includes(12)) {
      $(".edit-expense").addClass("btn-disabled");
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
      // throw error;
    }
  };

  const populateRegs = (regs, cats) => {
    const catMap = new Map(cats.map((cat) => [cat.id_categoria, cat]));
    const populated = regs.map((ing) => {
      const cat = catMap.get(ing.id_categoria);
      return {
        ...ing,
        ...cat,
      };
    });
    return populated;
  };

  const setList = (data) => {
    const tbody = $("#gastos-table-body");
    tbody.empty();
    data.reverse().map((item) => {
      const row = `
        <tr class="text-center">
            <td class="px-6 py-4 border-b border-gray-200">${
              item.id_registro
            }</td>
                        <td class="px-6 py-4 border-b border-gray-200">${
                          item.nombre_registro
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
                    <button class="edit-expense btn btn-sm btn-info" data-id="${
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

  const generateInsertModal = () => {
    $("#id-display").remove();

    $("#expense-form-title").html("Registrar nuevo ingreso");
    $("#expense-form-btn").html("Agregar");

    $("#edit-expense-form").attr("id", "register-expense-form");
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

    // optional operation
    // const expenseData = fetchexpense(expenseId);
    // //TODO fetch expense data based on their ID and fill the form inputs
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

  const refetchList = async () => {
    const newRegs = await fetchExpense();
    populatedRegs = populateRegs(newRegs, cats);
    setList(populatedRegs);
  };

  const cats = await fetchCategories();

  setCategories(cats);

  const regs = await fetchExpense();

  let populatedRegs = populateRegs(regs, cats);

  setList(populatedRegs);

  handleFilter("filtro_nombre_categoria", "id_categoria", populatedRegs);
  handleFilter("filtro_metodo_registro", "metodo_registro", populatedRegs);
  handleFilter("filtro_estado_registro", "estado_registro", populatedRegs);

  $("#fecha-inicial, #fecha-final").on("input", function () {
    const startDate = new Date($("#fecha-inicial").val());
    const endDate = new Date($("#fecha-final").val());

    if (!startDate || !endDate || startDate > endDate) {
      return;
    }

    const filteredData = filterByDateRange(populatedRegs, startDate, endDate);
    setList(filteredData);
  });

  $("#register-expense-btn").click(function () {
    generateInsertModal();
    modalGasto.showModal();
  });

  $(document).on("click", ".toggle-status", function () {
    const expenseId = $(this).data("id");

    const data = `id_registro=${expenseId}&estado_registro=anulado`;

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

  $(document).on("submit", "#register-expense-form", (e) => {
    e.preventDefault();
    const formData = $("#register-expense-form").serialize();
    $.ajax({
      url: "router.php?route=create-expense",
      type: "POST",
      data: formData,
      success: function (response) {
        $("#close-modal").trigger("submit");
        refetchList();
        $("#register-expense-form").trigger("reset");
        console.log("Register successful:", response);
      },
      error: function (xhr, status, error) {
        console.error("Error creating:", error);
      },
    });
  });

  $(document).on("click", ".edit-expense", function () {
    const expenseId = $(this).data("id");
    console.log("Editing expense with ID:", expenseId);

    generateEditModal(expenseId);

    modalGasto.showModal();
  });
  $(document).on("submit", "#edit-expense-form", (e) => {
    e.preventDefault();

    const formData = $("#edit-expense-form").serialize();

    $.ajax({
      url: "router.php?route=edit-reg",
      type: "PUT",
      data: formData,
      success: function (response) {
        $("#close-modal").trigger("submit");
        refetchList();
        $("#edit-expense-form").trigger("reset");
        console.log("Update successful:", response);
      },
      error: function (xhr, status, error) {
        console.error("Error updating:", error);
      },
    });
  });

  handleAuth(perms);
});
