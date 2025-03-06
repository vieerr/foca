$(document).ready(async () => {


  const handleAuth = (perms) => {
    console.log(admin);
    if(admin)
    {
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
      // throw error;
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
      // throw error;
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
    handleAuth(perms);
  };

  const generateInsertModal = () => {
    $("#id-display").remove();

    $("#income-form-title").html("Registrar nuevo ingreso");
    $("#income-form-btn").html("Agregar");

    $("#edit-income-form").attr("id", "register-income-form");
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

    // optional operation
    // const incomeData = fetchIncome(incomeId);
    // //TODO fetch income data based on their ID and fill the form inputs
  };

  const handleFilter = (id, field, array) => {
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
    const newIncome = await fetchIngresos();
    populatedIncome = populateIngresosCats(newIncome, cats);
    setList(populatedIncome);
  };

  const cats = await fetchCategories();
  setCategories(cats);

  const income = await fetchIngresos();

  let populatedIncome = populateIngresosCats(income, cats);

  setList(populatedIncome);

  handleFilter("filtro_nombre_categoria", "id_categoria", populatedIncome);
  handleFilter("filtro_metodo_registro", "metodo_registro", populatedIncome);
  handleFilter("filtro_estado_registro", "estado_registro", populatedIncome);

  $("#fecha-inicial, #fecha-final").on("input", function () {
    const startDate = new Date($("#fecha-inicial").val());
    const endDate = new Date($("#fecha-final").val());

    if (!startDate || !endDate || startDate > endDate) {
      return;
    }

    const filteredData = filterByDateRange(populatedIncome, startDate, endDate);
    setList(filteredData);
  });

  $("#register-income-btn").click(function () {
    generateInsertModal();
    modalIngreso.showModal();
  });

  $(document).on("click", ".toggle-status", function () {
    const incomeId = $(this).data("id");
    console.log({incomeId});

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

  $(document).on("submit", "#register-income-form", (e)=>
  {
    e.preventDefault();
    const formData = $("#register-income-form").serialize();
    $.ajax({
      url: "router.php?route=create-income",
      type: "POST",
      data: formData,
      success: function (response) {
        $("#close-modal").trigger("submit");
        refetchList();
        $("#register-income-form").trigger("reset");
        console.log("Register successful:", response);
      },
      error: function (xhr, status, error) {
        console.error("Error creating:", error);
      },
    });
  });

  $(document).on("click", ".edit-income", function () {
    const incomeId = $(this).data("id");
    console.log("Editing income with ID:", incomeId);

    generateEditModal(incomeId);

    modalIngreso.showModal();
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
});
