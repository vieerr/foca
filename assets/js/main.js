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
      route: "reporters",
      icon: "fa-chart-line",
      name: "Reporters",
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
  ];

  let html = "";
  $.each(links, function (index, link) {
    html += `
    <li>
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
        $("#main-content").html(response);

        // const previousScript = document.querySelector(
        //   `script[src="assets/js/${route}.js"]`,
        // );
        // if (previousScript) {
        //   previousScript.remove();
        // }
        const script = document.createElement("script");
        script.src = `assets/js/${route}.js`;
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
