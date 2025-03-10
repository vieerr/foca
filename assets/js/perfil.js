$(document).on("submit", "#change-password-form", function (e) {
  e.preventDefault();

  $("#confirm-password", this).prop("disabled", true);
  const formData = $("#change-password-form").serialize();

  // Send the AJAX request
  $.ajax({
    url: "router.php?route=edit-user",
    type: "PUT",
    contentType: "application/json", // Set the content type to JSON
    data: formData, // Convert the data object to a JSON string
    success: function (response) {
      alert("Contraseña actualizada");
      $("#password").val("");
    },
    error: function (xhr, status, error) {
      console.error("Error updating:", error);
    },
  });
});
