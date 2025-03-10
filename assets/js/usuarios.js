$(document).ready(function () {

  const handleAuth = (perms) => {
    console.log(admin);
    if (admin) {
      return;
    }
    if (!perms.includes(5)) {
      $("#register-user-btn").addClass("btn-disabled");
    }
    if (!perms.includes(10)) {
      $(".toggle-status").addClass("btn-disabled");
    }
    if (!perms.includes(15)) {
      $(".edit-user").addClass("btn-disabled");
    }
  };
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
      },
    });
  }

  function fetchUsers() {
    $.ajax({
      url: "router.php?route=get-users",
      method: "GET",
      dataType: "json",
      success: function (response) {
        $("#users-table-body").empty();

        response.map(function (user) {
          const row = `
            <tr class="text-center">
              <td class="px-6 py-4 border-b border-gray-200">${
                user.id_usuario
              }</td>
              <td class="px-6 py-4 border-b border-gray-200">${
                user.nombre_usuario
              }</td>
              <td class="px-6 py-4 border-b border-gray-200">${
                user.apellido_usuario
              }</td>
              <td class="px-6 py-4 border-b border-gray-200">${
                user.username_usuario
              }</td>
              <td class="px-6 py-4 border-b border-gray-200">${
                user.nombre_rol
              }</td>
              <td class="py-3">
                <span class=" ${
                  user.estado_usuario === "activo"
                    ? "text-[#2db086]"
                    : "text-[#e73f5b]"
                }">
                  ${user.estado_usuario}
                </span>
              </td>
              <td class="py-3">
                <div class="flex justify-center">
                  <button class="edit-user btn btn-sm w-32 btn-info" data-id="${
                    user.id_usuario
                  }">
                      <i class="fas fa-pencil text-white"></i>
                      <p class="hidden lg:inline-block text-white">Editar</p>
                  </button>
  
                  <button style="color:white" class="btn btn-sm text-white w-32 btn-error ml-2 toggle-status" data-id="${
                    user.id_usuario
                  }" data-status="${user.estado_usuario}">
                      <i class="fas fa-retweet text-white"></i>
                      <p class="hidden lg:inline-block text-white">
                        ${
                          user.estado_usuario === "activo"
                            ? "Desactivar"
                            : "Activar"
                        }
                      </p>
                  </button>
                </div>
              </td>
            </tr>
          `;
          $("#users-table-body").append(row);
        });
        handleAuth(perms);
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
      rol: $("#rol").val(),
    };

    // Validaciones
    if (Object.values(formData).some((value) => value === "")) {
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
        $("#close-modal").trigger("submit");
        fetchUsers();
        $("#edit-user-form").trigger("reset");
        console.log("Respuesta del servidor:", response);
        if (response.success) {
          alert("Usuario registrado exitosamente.");
          return;
        } else {
          alert("Error al registrar el usuario: " + response.message);
        }
      },
      error: function (xhr, status, error) {
        console.error("Error en la solicitud AJAX:", error);
        alert("Ocurrió un error. Intente nuevamente.");
      },
    });
  }

  function generateInsertModal() {
    $("#id-display").remove();

    $("#user-form-title").html("Registrar nuevo usuario");
    $("#user-form-btn").html("Agregar");

    $("#edit-user-form").attr("id", "register-user-form");
    $("#register-user-form").trigger("reset");
  }

  function generateEditModal(userId) {
    $("#user-form-title").html("Editar usuario");
    $("#user-form-btn").html("Actualizar");

    $("#register-user-form").attr("id", "edit-user-form").data("id", userId);;

    if ($("#id-display").length) {
      $("#id_usuario").val(userId);
    } else {
      $("#edit-user-form").prepend(`
        <div id="id-display">
          <label class="block text-sm font-medium text-gray-700" for="id_usuario">ID:</label>
          <input class="mt-1 block w-full p-2 border border-gray-300 rounded-lg bg-white" type="text" name="id_usuario" id="id_usuario" value="${userId}" readonly>
        </div>`);
    }

    $.ajax({
      url: `router.php?route=get-one-user`,
      method: "POST",
      data: { id_usuario: userId },
      success: function (response) {
        console.log("Usuario encontrado:", response);
        $("#nombre").val(response.nombre_usuario);
        $("#apellido").val(response.apellido_usuario);
        $("#username").val(response.username_usuario);
        $("#rol").val(response.id_rol);
      },
      error: function (xhr, status, error) {
        console.error("Error fetching expense:", error);
      },
    });
  };

  fetchUsers();
  fetchRoles();

  $(document).on("click", ".edit-user", function () {
    const userId = $(this).data("id");
    generateEditModal(userId);
    modalUsuario.showModal();
  });

  $("#register-user-btn").click(function () {
    generateInsertModal();
    modalUsuario.showModal();
  });
  $(document).on("click", ".toggle-status", function () {
    const userId = $(this).data("id");
    const currentStatus = $(this).data("status") === "activo" ? true : false;
    const nextStatus = !currentStatus;
    const statusMsg = nextStatus ? "activar" : "desactivar";
    const newStatus = nextStatus ? "activo" : "inactivo";

    const data = `id_usuario=${userId}&estado_usuario=${newStatus}`;

    if (
      confirm(
        `¿Estás seguro que deseas ${statusMsg} este usuario?`
      )
    ) {
      $.ajax({
        url: "router.php?route=edit-user",
        type: "PUT",
        data: data,
        success: function (response) {
          fetchUsers();
          console.log("Update successful:", response);
        },
        error: function (xhr, status, error) {
          console.error("Error updating:", error);
        },
      });
    }
  });
  $(document).on("submit", "#register-user-form", submitUser);
  $(document).on("submit", "#edit-user-form", (e) => {
    e.preventDefault();

    const formData = $("#edit-user-form").serialize();

    $.ajax({
      url: "router.php?route=edit-user",
      type: "PUT",
      data: formData,
      success: function (response) {
        $("#close-modal").trigger("submit");
        fetchUsers();
        $("#edit-user-form").trigger("reset");
        console.log("Update successful:", response);
      },
      error: function (xhr, status, error) {
        console.error("Error updating:", error);
      },
    });
  });
});
