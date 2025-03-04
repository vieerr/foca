$(document).ready(function () {

  fetchUsers();
  fetchRoles();

  $(document).on("click", ".edit-user", function () {
    const userId = $(this).data("id");
    generateEditModal(userId);
    modalUsuario.showModal();
  });

  $("#register-user-btn").click(function(){
    generateInsertModal();
		modalUsuario.showModal();
	});


  // $(document).on("click", ".toggle-status", function () {
  //   const userId = $(this).data("id");
  //   const newStatus =
  //     $(this).data("status") === "activo" ? "inactivo" : "activo";

  //   $.ajax({
  //     url: "app/controllers/update_user_status.php",
  //     method: "POST",
  //     data: { id: userId, status: newStatus },
  //     success: function (response) {
  //       alert("Estado actualizado correctamente.");
  //       fetchUsers();
  //     },
  //     error: function (xhr, status, error) {
  //       console.error("Error updating user status:", error);
  //       alert("Error al actualizar el estado. Please try again.");
  //     },
  //   });
  // });
});

$(document).on("submit","#register-user-form", submitUser);
$(document).on("submit","#edit-user-form", updateUser);


function fetchRoles() {
  $.ajax({
    url: "router.php?route=get-roles",
    method: "GET",
    dataType: "json",
    success: function (response) {
      console.log("Roles recibidos:", response);
      $("#rol").empty().append('<option value="">Seleccione un rol</option>');

      response.forEach(function (rol) {
        const option = `<option value="${rol.id_rol}">${rol.nombre_rol}</option>`;
        $("#rol").append(option);
      });
    },
    error: function (xhr, status, error, response) {
      console.error("Error al obtener los roles:", error, response);
      alert("Error al cargar los roles. Por favor, intenta nuevamente.");
    }
  });
}

function fetchUser(id){
  //TODO
}

function fetchUsers() {
  $.ajax({
    url: "router.php?route=get-users",
    method: "GET",
    dataType: "json",
    success: function (response) {
      $("#users-table-body").empty();

      response.forEach(function (user) {
        const row = `
          <tr class="text-center">
            <td class="px-6 py-4 border-b border-gray-200">${user.id_usuario}</td>
            <td class="px-6 py-4 border-b border-gray-200">${user.nombre_usuario}</td>
            <td class="px-6 py-4 border-b border-gray-200">${user.apellido_usuario}</td>
            <td class="px-6 py-4 border-b border-gray-200">${user.username_usuario}</td>
            <td class="px-6 py-4 border-b border-gray-200">${user.nombre_rol}</td>
            <td class="py-3">
              <span class="badge ${user.estado_usuario === "activo" ? "badge-accent" : "badge-error"} badge-outline">
                ${user.estado_usuario}
              </span>
            </td>
            <td class="py-3">
              <div class="inline-flex">
                <button class="edit-user btn btn-sm btn-info" data-id="${user.id_usuario}">
                    <i class="fas fa-pencil"></i>
                    <p class="hidden lg:inline-block">Editar</p>
                </button>

                <button class="btn btn-sm btn-error ml-2 toggle-status" data-id="${user.id_usuario}" data-status="${user.estado_usuario}">
                    <i class="fas fa-retweet"></i>
                    <p class="hidden lg:inline-block">
                      ${user.estado_usuario === "activo" ? "Desactivar" : "Activar"}
                    </p>
                </button>
              </div>
            </td>
          </tr>
        `;
        $("#users-table-body").append(row);
      });
    },
    error: function (xhr, status, error) {
      console.error("Error fetching user data:", error);
      alert("Error fetching user data. Please try again.");
    },
  });
}

function submitUser(event) {
  event.preventDefault();
  const formData = {
    nombre: $("#nombre").val().trim(),
    apellido: $("#apellido").val().trim(),
    username: $("#username").val().trim(),
    password: $("#password").val().trim(),
    rol: $("#rol").val()
  };

  // Validaciones
  if (Object.values(formData).some(value => value === "")) {
    alert("Por favor, complete todos los campos obligatorios.");
    return;
  }

  // Enviar datos
  $.ajax({
    url: "router.php?route=crear-usuario",
    method: "POST",
    data: formData,
    dataType: "json",
    success: function (response) {
      console.log("Respuesta del servidor:", response);
      if (response.success) {
        alert("Usuario registrado exitosamente.");
        $("#register-user-form")[0].reset();
      } else {
        alert("Error al registrar el usuario: " + response.message);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error en la solicitud AJAX:", error);
      alert("Ocurrió un error. Intente nuevamente.");
    }
  });
}

function updateUser(event){
  event.preventDefault();
  //TODO
}

function generateInsertModal(){
  $("#id-display").remove();

  $("#user-form-title").html("Registrar nuevo usuario");
  $("#user-form-btn").html("Agregar");

  $("#edit-user-form").attr("id", "register-user-form");
}


function generateEditModal(userId){
  $("#user-form-title").html("Editar usuario");
  $("#user-form-btn").html("Actualizar");

  $("#register-user-form").attr("id", "edit-user-form");

  if ($("#id-display").length) {
    $("#id_usuario").val(userId);
  } else {
    $("#edit-user-form").prepend(`
      <div id="id-display">
        <label class="block text-sm font-medium text-gray-700" for="id_usuario">ID:</label>
        <input class="mt-1 block w-full p-2 border border-gray-300 rounded-lg bg-white" type="text" name="id_usuario" id="id_usuario" value="${userId}" readonly>
      </div>`);
  }
  
  const userData = fetchUser(userId);
  //TODO fetch user data based on their ID and fill the form inputs
  
}