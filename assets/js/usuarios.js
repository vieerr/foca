$(document).ready(function () {
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

  fetchUsers();

  // $("#register-user-form").on("submit", function (e) {
  //   e.preventDefault();

  //   const formData = {
  //     nombre: $("#nombre").val(),
  //     apellido: $("#apellido").val(),
  //     username: $("#username").val(),
  //     password: $("#password").val(),
  //     rol: $("#rol").val(),
  //   };

  //   $.ajax({
  //     url: "app/controllers/register_user.php",
  //     method: "POST",
  //     data: formData,
  //     success: function (response) {
  //       alert("Usuario registrado correctamente.");
  //       fetchUsers();
  //     },
  //     error: function (xhr, status, error) {
  //       console.error("Error registering user:", error);
  //       alert("Error al registrar el usuario. Please try again.");
  //     },
  //   });
  // });

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
