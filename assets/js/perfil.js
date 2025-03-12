$(document).on("submit", "#change-password-form", function (e) {
  e.preventDefault();

  $("#confirm-password", this).prop("disabled", true);
  const formData = $("#change-password-form").serialize();

  
  $.ajax({
    url: "router.php?route=edit-user",
    type: "PUT",
    contentType: "application/json", 
    data: formData, 
    success: function (response) {
      alert("Contraseña actualizada");
      $("#password").val("");
    },
    error: function (xhr, status, error) {
      console.error("Error updating:", error);
    },
  });
});
