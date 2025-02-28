$(document).ready(function () {

  fetchUsers();
  fetchRoles();
  $("#register-user-form").on("submit", submitUser);

  $(document).on("click", ".edit-user", function () {
    const userId = $(this).data("id");

    alert(`Edit user with ID: ${userId}`);
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

function fetchUsers() {
  $.ajax({
    url: "router.php?route=get-users",
    method: "GET",
    dataType: "json",
    success: function (response) {
      $("#users-table-body").empty();
      console.log(response);

      response.forEach(function (user) {
        const row = `
          <tr>
            <td class="px-6 py-4 border-b border-gray-200">${user.id_usuario}</td>
            <td class="px-6 py-4 border-b border-gray-200">${user.nombre_usuario}</td>
            <td class="px-6 py-4 border-b border-gray-200">${user.apellido_usuario}</td>
            <td class="px-6 py-4 border-b border-gray-200">${user.username_usuario}</td>
            <td class="px-6 py-4 border-b border-gray-200">${user.nombre_rol}</td>
            <td class="px-6 py-4 border-b border-gray-200">
              <span class="px-2 py-1 text-sm rounded-full ${user.estado_usuario === "activo" ? "bg-green-100 text-green-800" : "bg-red-100 text-red-800"}">
                ${user.estado_usuario}
              </span>
            </td>
            <td class="px-6 py-4 border-b border-gray-200">
              <button class="btn btn-sm btn-outline btn-primary edit-user" data-id="${user.id_usuario}">Editar</button>
              <button class="btn btn-sm btn-outline btn-secondary toggle-status" data-id="${user.id_usuario}" data-status="${user.estado_usuario}">
                ${user.estado_usuario === "activo" ? "Desactivar" : "Activar"}
              </button>
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
    error: function (xhr, status, error) {
      console.error("Error al obtener los roles:", error);
      alert("Error al cargar los roles. Por favor, intenta nuevamente.");
    }
  });
}