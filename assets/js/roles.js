$(document).ready(function () {
    fetchPermisos();
    $("#register-rol-form").on("submit", function (e) {
        e.preventDefault();
        submitRol();
      });
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
      }
    });
  }

  function submitRol() {
    const nombreRol = $("#nombre_rol").val().trim();
    const descripcionRol = $("#descripcion_rol").val().trim();
    const permisos = $("input[name='permiso[]']:checked")
      .map(function() {
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
        permisos: permisos
      },
      dataType: "json",
      success: function(response) {
        console.log("Respuesta del servidor:", response);
        if (response.success) {
          alert("Rol registrado exitosamente.");
          $("#register-rol-form")[0].reset();
        } else {
          alert("Error al registrar el rol: " + response.message);
        }
      },
      error: function(xhr, status, error) {
        console.error("Error en la solicitud AJAX:", error);
        alert("Ocurrió un error. Intente nuevamente.");
      }
    });
  }
  
  