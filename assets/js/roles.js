$(document).ready(function () {
  const handleAuth = (perms) => {
    console.log(admin);
    if (admin) {
      return;
    }
    if (!perms.includes(4)) {
      $("#register-role-btn").addClass("btn-disabled");
    }
    if (!perms.includes(9)) {
      $(".toggle-status").addClass("btn-disabled");
    }
    if (!perms.includes(14)) {
      $(".edit-role").addClass("btn-disabled");
    }
  };

  fetchPermisos();
  fetchRoles();
  handleAuth(perms);


  $(document).on("click", ".edit-role", function () {
    const roleId = $(this).data("id");
    generateEditModal(roleId);
    modalRol.showModal();
  });

  $("#register-role-btn").click(function () {
    generateInsertModal();
    modalRol.showModal();
  });
});

$(document).on("submit", "#register-role-form", submitRole);
$(document).on("submit", "#edit-role-form", updateRole);

$(document).on("click", ".toggle-status", function () {
  const id = $(this).data("id");
  const newStatus = $(this).data("status") === "activo" ? "inactivo" : "activo";

  const data = `id_rol=${id}&estado_rol=${newStatus}`;

  if (
    confirm(
      `¿Estás seguro que deseas ${
        newStatus === "inactivo" ? "desactivar" : "activar"
      } este rol?`
    )
  ) {
    $.ajax({
      url: "router.php?route=edit-rol",
      type: "PUT",
      data: data,
      success: function (response) {
        fetchRoles();
        console.log("Update successful:", response);
      },
      error: function (xhr, status, error) {
        console.error("Error updating:", error);
      },
    });
  }
});

function fetchPermisos() {
  $.ajax({
    url: "router.php?route=get-permisos",
    method: "GET",
    dataType: "json",
    success: function (response) {
      console.log("Permisos recibidos:", response);
      $("#permisos").empty();
      response.forEach(function (permiso) {
        const checkbox = `
          <div class="form-check">
            <input class="form-check-input" type="checkbox" value="${permiso.id_permiso}" id="permiso${permiso.id_permiso}" name="permiso[]">
            <label class="form-check-label" for="permiso${permiso.id_permiso}">
              ${permiso.nombre_permiso}
            </label>
          </div>
        `;
        $("#permisos").append(checkbox);
      });
    },
    error: function (xhr, status, error) {
      console.error("Error al obtener los permisos:", error);
      alert("Error al cargar los permisos. Por favor, intenta nuevamente.");
    },
  });
}

function fetchRoles() {
  $.ajax({
    url: "router.php?route=get-roles",
    method: "GET",
    dataType: "json",
    success: function (response) {
      $("#roles-table-body").empty();
      console.log("Roles recibidos:", response);
      response.forEach(function (role) {
        const row = `
          <tr class="text-center">
            <td class="px-6 py-4 border-b border-gray-200">${role.id_rol}</td>
            <td class="px-6 py-4 border-b border-gray-200">${
              role.nombre_rol
            }</td>
            <td class="py-3">
              <span class="badge ${
                role.estado_rol === "activo" ? "badge-accent" : "badge-error"
              } badge-outline">
                ${role.estado_rol}
              </span>
            </td>
            <td class="py-3">
              <div class="inline-flex">
                <button class="edit-role btn btn-sm btn-info" data-id="${
                  role.id_rol
                }">
                    <i class="fas fa-pencil"></i>
                    <p class="hidden lg:inline-block">Editar</p>
                </button>
                <button class="btn btn-sm btn-error ml-2 toggle-status" data-id="${
                  role.id_rol
                }" data-status="${role.estado_rol}">
                    <i class="fas fa-retweet"></i>
                    <p class="hidden lg:inline-block">
                      ${role.estado_rol === "activo" ? "Desactivar" : "Activar"}
                    </p>
                </button>
              </div>
            </td>
          </tr>
        `;
        $("#roles-table-body").append(row);
      });
    },
    error: function (xhr, status, error) {
      console.error("Error fetching roles data:", error);
      alert("Error fetching roles data. Please try again.");
    },
  });
}

function submitRole(event) {
  event.preventDefault();
  const nombreRol = $("#nombre_rol").val().trim();
  const descripcionRol = $("#descripcion_rol").val().trim();
  const permisos = $("input[name='permiso[]']:checked")
    .map(function () {
      return $(this).val();
    })
    .get();

  if (nombreRol === "" || descripcionRol === "") {
    alert("Por favor, complete todos los campos obligatorios.");
    return;
  }
  if (permisos.length === 0) {
    alert("Por favor, seleccione al menos un permiso.");
    return;
  }

  $.ajax({
    url: "router.php?route=crear-rol",
    method: "POST",
    data: {
      nombre_rol: nombreRol,
      descripcion_rol: descripcionRol,
      permisos: permisos,
    },
    dataType: "json",
    success: function (response) {
      console.log("Respuesta del servidor:", response);
      $("#close-modal").trigger("submit");
      fetchRoles();
      $("#register-role-form").trigger("reset");
      if (response.success) {
        alert("Rol registrado exitosamente.");
      } else {
        alert("Error al registrar el rol: " + response.message);
      }
    },
    error: function (xhr, status, error) {
      console.error("Error en la solicitud AJAX:", error);
      alert("Ocurrió un error. Intente nuevamente.");
    },
  });
}

function updateRole(event) {
  event.preventDefault();
  const idRol = $(this).data("id");
  const nombreRol = $("#nombre_rol").val().trim();
  const descripcionRol = $("#descripcion_rol").val().trim();
  const permisos = $("input[name='permiso[]']:checked")
    .map(function () {
      return $(this).val();
    })
    .get();
  if (permisos.length === 0) {
    alert("Por favor, seleccione al menos un permiso.");
    return;
  }

  $.ajax({
    url: "router.php?route=edit-rol",
    method: "PUT",
    data: {
      id_rol: idRol,
      nombre_rol: nombreRol,
      descripcion_rol: descripcionRol,
      permisos: permisos,
    },
    dataType: "json",
    success: function (response) {
      console.log("Respuesta del servidor:", response);
      $("#close-modal").trigger("submit");
      fetchRoles();
      $("#edit-role-form").trigger("reset");
      if (response.success) {
        alert("Rol registrado exitosamente.");
      } else {
        alert("Error al registrar el rol: " + response.message);
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

  $("#role-form-title").html("Registrar nuevo rol");
  $("#role-form-btn").html("Agregar");

  $("#edit-role-form").attr("id", "register-role-form");
}

function generateEditModal(roleId) {
  $("#role-form-title").html("Editar rol");
  $("#role-form-btn").html("Actualizar");

  $("#register-role-form").attr("id", "edit-role-form").data("id", roleId);

  if ($("#id-display").length) {
    $("#id_rol").val(roleId);
  } else {
    $("#income-form-wrapper").prepend(`
      <div id="id-display">
        <label class="block text-sm font-medium text-gray-700" for="id_rol">ID:</label>
        <input class="mt-1 block w-full p-2 border border-gray-300 rounded-lg bg-white" type="text" name="id_rol" id="id_rol" value="${roleId}" readonly>
      </div>`);
  }
}
