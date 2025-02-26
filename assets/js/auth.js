$(document).ready(function () {
  // Handle login form submission
  $("#loginForm").on("submit", function (e) {
    e.preventDefault();
    const formData = $(this).serialize();
    $.ajax({
      url: "routes/login.php",
      method: "POST",
      data: formData,
      success: function (response) {
        const data = JSON.parse(response);
        if (data.success) {
          window.location.href = data.redirect;
        } else {
          alert(data.message);
        }
      },
      error: function (error) {
        console.log(error);
        alert("An error occurred. Please try again." + error.message);
      },
    });
  });

  // Handle logout
  $("#logoutButton").on("click", function (e) {
    e.preventDefault();

    $.ajax({
      url: "routes/logout.php",
      method: "GET",
      success: function (response) {
        console.log(response);
        const data = JSON.parse(response);
        if (data.success) {
          window.location.href = data.redirect;
        }
      },
      error: function () {
        alert("An error occurred. Please try again.");
      },
    });
  });
});
