$(document).ready(() => {
  fetchCategorias();
  fetchGastos();

  $(document).on("click", ".edit-expense", function () {
    const expenseId = $(this).data("id");
    generateEditModal(expenseId);
    modalGasto.showModal();
  });

  $("#register-expense-btn").click(function(){
    generateInsertModal();
		modalGasto.showModal();
	});
});

$(document).on("submit","#register-expense-form", submitExpense);
$(document).on("submit","#edit-expense-form", updateExpense);

function fetchCategorias(){
  //TODO --Obtener las categorías para gastos
  //$("#nombre_categoria").empty().append('<option value="">Seleccione una categoría</option>');
  // Colocar las categorías obtenidas en $("#nombre_categoria").append()

  // Realizar lo mismo para el filtro
  //$("#filtro_nombre_categoria").empty().append('<option value="">Seleccione una categoría</option>');
  // Colocar las categorías obtenidas en $("#filtro_nombre_categoria").append()
}

function fetchExpense(id){
  //TODO
}

function fetchGastos(){
  //TODO
}

function submitExpense(event){
  event.preventDefault();
  //TODO
  alert("Ingreso registrado");
}

function updateExpense(event){
  event.preventDefault();
  //TODO
  alert("Ingreso editado");
}

function generateInsertModal(){
  $("#id-display").remove();

  $("#expense-form-title").html("Registrar nuevo gasto");
  $("#expense-form-btn").html("Agregar");

  $("#edit-expense-form").attr("id", "register-expense-form");
}


function generateEditModal(expenseId){
  $("#expense-form-title").html("Editar gasto");
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
  
  const expenseData = fetchExpense(expenseId);
  //TODO fetch expense data based on their ID and fill the form inputs
  
}