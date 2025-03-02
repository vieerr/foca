$(document).ready(() => {
  fetchCategorias();
  fetchIngresos();

  $(document).on("click", ".edit-income", function () {
    const incomeId = $(this).data("id");
    generateEditModal(incomeId);
    modalIngreso.showModal();
  });

  $("#register-income-btn").click(function(){
    generateInsertModal();
		modalIngreso.showModal();
	});
});

$(document).on("submit","#register-income-form", submitIncome);
$(document).on("submit","#edit-income-form", updateIncome);

function fetchCategorias(){
  //TODO --Obtener las categorías para ingresos
  //$("#nombre_categoria").empty().append('<option value="">Seleccione una categoría</option>');
  // Colocar las categorías obtenidas en $("#nombre_categoria").append()

  // Realizar lo mismo para el filtro
  //$("#filtro_nombre_categoria").empty().append('<option value="">Seleccione una categoría</option>');
  // Colocar las categorías obtenidas en $("#filtro_nombre_categoria").append()
}

function fetchIncome(id){
  //TODO
}

function fetchIngresos(){
  //TODO
}

function submitIncome(event){
  event.preventDefault();
  //TODO
  alert("Ingreso registrado");
}

function updateIncome(event){
  event.preventDefault();
  //TODO
  alert("Ingreso editado");
}

function generateInsertModal(){
  $("#id-display").remove();

  $("#income-form-title").html("Registrar nuevo ingreso");
  $("#income-form-btn").html("Agregar");

  $("#edit-income-form").attr("id", "register-income-form");
}


function generateEditModal(incomeId){
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
  
  const incomeData = fetchIncome(incomeId);
  //TODO fetch income data based on their ID and fill the form inputs
  
}