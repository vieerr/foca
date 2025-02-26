$(document).ready(function () {
  // Function to fetch and populate user data
  function fetchUsers() {
    $.ajax({
      url: "router.php?page=get-users", // Endpoint to fetch users
      method: "GET",
      dataType: "json",
      success: function (response) {
        // Clear the table body
        $("#users-table-body").empty();
        console.log(response);
        // Loop through the response data and append rows to the table
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
      error: function () {
        alert("Error fetching user data.");
      },
    });
  }

  // Fetch users on page load
  fetchUsers();
});
