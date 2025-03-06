// this can be called from any other script, refactor reusable code here
// const test = () => {
//   console.log("test");
// };

let perms = [];
let admin = false;

const getRolPerms = async (rol) => {
  return new Promise((resolve, reject) => {
    $.ajax({
      url: "router.php?route=get-rol-perms",
      method: "POST",
      data: {
        id_rol: rol,
      },
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
  ];

  const editSidebar = async () => {
    // not implemented yet
    // if (perms.includes(1, 8, 11) || admin) {
    //   console.log("categorias");
    // }

    const gastos = [2, 6, 12];
    const ingresos = [3, 7, 13];
    const roles = [4, 9, 14];
    const usuarios = [5, 10, 15];
    const reportes = [16];

    if (perms.some((el) => gastos.includes(el)) || admin) {
      links.push({
        route: "gastos",
        icon: "fa-wallet",
        name: "Gastos",
      });
      console.log("gastos");
    }
    if (perms.some((el) => ingresos.includes(el)) || admin) {
      links.push({
        route: "ingresos",
        icon: "fa-money-bill-wave",
        name: "Ingresos",
      });
      console.log("ingresos");
    }
    if (perms.some((el) => roles.includes(el)) || admin) {
      links.push({
        route: "roles",
        icon: "fa-shield-halved",
        name: "Roles",
      });
      console.log("roles");
    }
    if (perms.some((el) => usuarios.includes(el)) || admin) {
      links.push({
        route: "usuarios",
        icon: "fa-user-group",
        name: "Usuarios",
      });
      console.log("usuarios");
    }
    if (perms.some((el) => reportes.includes(el)) || admin) {
      links.push({
        route: "reportes",
        icon: "fa-chart-line",
        name: "Reportes",
      });
      console.log("reportes");
    }
    if (admin) {
      links.push({
        route: "auditorias",
        icon: "fa-clipboard-list",
        name: "Auditorias",
      });
      console.log("auditorias");
    }
  };

  await editSidebar();
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

  $("#sidebar-links")
    .html(html)
    .append(
      `
    <li class="w-full">
        <a href="router.php?route=logout" class="btn btn-error mt-7 gap-5 flex items-center p-2 rounded-lg hover:bg-base-300 transition-colors">
            <i class="fas fa-sign-out-alt"></i>
            Cerrar sesión
        </a>
    </li>
    `
    );

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
