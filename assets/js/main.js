// this can be called from any other script, refactor reusable code here
// const test = () => {
//   console.log("test");
// };

let perms = [];
let admin = false;

const getRolPerms = async () => {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "router.php?route=get-rol-perms",
      method: "GET",
      success: function (response) {
        resolve(response.map((perm) => Number(perm.id_permiso)));
      },
      error: function () {
        $("#main-content").html("<p>Error loading content.</p>");
        reject();
      },
    });
  });
};

const isAdmin = async () => {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "router.php?route=is-admin",
      method: "GET",
      success: function (response) {
        resolve(response === "true");
      },
      error: function () {
        $("#main-content").html("<p>Error loading content.</p>");
        reject();
      },
    });
  });
};

getRolPerms()
  .then((pms) => {
    perms = pms;
  })
  .catch((error) => {
    console.error("Error:", error);
  });

isAdmin()
  .then((adm) => {
    admin = adm;
    console.log({ adm });
  })
  .catch((error) => {
    console.error("Error:", error);
  });

$(document).ready(async function () {
  const links = [
    {
      route: "dashboard",
      icon: "fa-home",
      name: "Dashboard",
    },
    {
      route: "perfil",
      icon: "fa-user",
      name: "Perfil",
    },
    {
      route: "gastos",
      icon: "fa-wallet",
      name: "Gastos",
    },
    {
      route: "ingresos",
      icon: "fa-money-bill-wave",
      name: "Ingresos",
    },
    {
      route: "reportes",
      icon: "fa-chart-line",
      name: "Reportes",
    }
  ];

  const editSidebar = async () => {
    // not implemented yet
    // if (perms.includes(1, 8, 11) || admin) {
    //   console.log("categorias");
    // }

    const userPerms = await getRolPerms();

    const roles = [4, 9, 14];
    const usuarios = [5, 10, 15];
    const reportes = [16];

    console.log(userPerms);

    if (userPerms.some((el) => roles.includes(el)) || admin) {
      links.push({
        route: "roles",
        icon: "fa-shield-halved",
        name: "Roles",
      });
      console.log("roles");
    }
    if (userPerms.some((el) => usuarios.includes(el)) || admin) {
      links.push({
        route: "usuarios",
        icon: "fa-user-group",
        name: "Usuarios",
      });
      console.log("usuarios");
    }
    if (admin) {
      links.push({
        route: "auditorias",
        icon: "fa-clipboard-list",
        name: "Auditorias",
      });
      console.log("auditorias");
    }

    let html = "";
    $.each(links, function (index, link) {
      html += `
      <li id=${link.route}-link class="w-full">
          <a href="#" data-route=${link.route} class="load-content rounded-md p-3 flex items-center gap-4 hover:bg-base-300 shrink-0">
              <i class="fas ${link.icon}"></i>
              <span class="grow-1">${link.name}</span>
          </a>
      </li>
      `;
    });

    $("#sidebar-links")
      .html(html)
      .append(
        `
      <li>
          <a href="router.php?route=logout" class="bg-[#FF637D] rounded-md p-2 flex items-center gap-5 shrink-0 hover:bg-[#ff4564]">
              <i class="fas fa-sign-out-alt text-white"></i>
              <span class="text-white font-bold">Cerrar sesión</span>
          </a>
      </li>
      `
      );
  };

  await editSidebar();

  $("#toggle-btn").click(function () {
    $("#sidebar").toggleClass("close");
    $("#toggle-icon").toggleClass("rotate-180");

    $("#sidebar-links li a span").fadeToggle(300);
  });

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
