$(document).ready(function () {
  // Handle sidebar link clicks
  $(".load-content").on("click", function (e) {
    e.preventDefault(); // Prevent default link behavior
    const route = $(this).data("route"); // Get the route from data-route attribute

    // Fetch content via AJAX
    $.ajax({
      url: `app/controllers/${route}.php`, // Adjust the path as needed
      method: "GET",
      success: function (response) {
        $("#main-content").html(response); // Update main content
      },
      error: function () {
        $("#main-content").html("<p>Error loading content.</p>");
      },
    });
  });

  // Load default content (e.g., dashboard) on page load
  $('[data-route="dashboard"]').click();
});
