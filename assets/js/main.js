

$(document).ready(function () {

  const links = [
    {
      route: "dashboard",
      icon: "fa-home",
      name: "Dashboard",
    },
    {
      route: "ingresos",
      icon: "fa-money-bill-wave",
      name: "Ingresos",
    },
    {
      route: "gastos",
      icon: "fa-wallet",
      name: "Gastos",
    },
    {
      route: "reportes",
      icon: "fa-chart-line",
      name: "Reportes",
    },
    {
      route: "perfil",
      icon: "fa-user",
      name: "Perfil",
    },
    {
      route: "usuarios",
      icon: "fa-user-group",
      name: "Usuarios",
    },
    {
      route: "roles",
      icon: "fa-shield-halved",
      name: "Roles",
    },
    {
      route: "auditorias",
      icon: "fa-clipboard-list",
      name: "Auditorias",
    },
  ];

  let html = "";
  $.each(links, function (index, link) {
    html += `
    <li id=${link.route}-link class="w-full">
        <a href="#" data-route=${link.route} class="load-content gap-5 flex items-center p-2 rounded-lg hover:bg-base-300 transition-colors">
            <i class="fas ${link.icon}"></i>
            ${link.name}
        </a>
    </li>
    `;
  });

  $("#sidebar-links").html(html);
  $(".load-content").on("click", function (e) {
    e.preventDefault();
    const route = $(this).data("route");
    console.log(route);
  
    $.ajax({
      url: `router.php?page=${route}`,
      method: "GET",
      success: function (response) {
        // Update the main content
        $("#main-content").html(response);
  
        // Remove all previously loaded scripts with the class "dynamic-script"
        document.querySelectorAll("script.dynamic-script").forEach((script) => {
          script.remove();
        });
  
        // Create and append the new script
        const script = document.createElement("script");
        script.src = `assets/js/${route}.js`;
        script.classList.add("dynamic-script"); // Add a class to identify dynamically loaded scripts
        script.onload = () => {
          console.log(`${route}.js loaded successfully`);
        };
        script.onerror = () => {
          console.error(`Error loading ${route}.js`);
        };
        document.head.appendChild(script);
      },
      error: function () {
        $("#main-content").html("<p>Error loading content.</p>");
      },
    });
  });

  $('[data-route="dashboard"]').click();
});
