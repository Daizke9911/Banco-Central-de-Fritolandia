const sideMenu = document.querySelector('.side-menu');
    const links = document.querySelectorAll('.side-menu a');
    const activeClass = 'active'; // Clase para el botón activo
    const inactiveClass = 'desactive'; // Clase para el botón inactivo
    const activeRouteKey = 'activeSidebarRoute'; // Clave para localStorage
  
    // Función para activar un enlace basado en su href
    function activateLink(href) {
      links.forEach(link => {
        if (link.getAttribute('href') === href) {
          link.classList.remove(inactiveClass);
          link.classList.add(activeClass);
        } else {
          link.classList.remove(activeClass);
          link.classList.add(inactiveClass);
        }
      });
    }
  
    // Al cargar la página, intenta restaurar el estado activo desde localStorage
    document.addEventListener('DOMContentLoaded', function() {
      const storedHref = localStorage.getItem(activeRouteKey);
      if (storedHref) {
        activateLink(storedHref);
      } else {
        // Si no hay nada en localStorage, activa el primer enlace por defecto
        if (links.length > 0) {
          links[0].classList.remove(inactiveClass);
          links[0].classList.add(activeClass);
          localStorage.setItem(activeRouteKey, links[0].getAttribute('href'));
        }
      }
    });
  
    // Escuchar los clics en el sidebar
    sideMenu.addEventListener('click', function(event) {
      const target = event.target.closest('a');
  
      if (target) {
        const href = target.getAttribute('href');
        activateLink(href);
        localStorage.setItem(activeRouteKey, href); // Guardar el href activo en localStorage
      }
    });