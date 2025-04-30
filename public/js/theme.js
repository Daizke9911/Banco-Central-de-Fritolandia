document.addEventListener('DOMContentLoaded', function() {
    if (window.sidebar) {
        const style = document.createElement('style');
        style.textContent = `:root {
            --sidebar: ${window.sidebar};
            --button-sidebar: ${window.buttonSidebar};
            --text-color-sidebar: ${window.textColorSidebar};
            --backgraund: ${window.backgraund};
          }`;
        document.head.appendChild(style);

        // Aplica el color a elementos específicos usando la variable CSS
        const elementsToColor = document.querySelectorAll('.sidebar, .otra-clase');
        elementsToColor.forEach(element => {
            element.style.backgroundColor = `var(--sidebar)`;
            // También puedes cambiar el color del texto u otras propiedades
            element.style.button = 'var(--button-sidebar)';
            element.style.textColor = 'var(--text-color-sidebar)';
            element.style.backgraund = 'var(--backgraund)';
        });
    }

    // Ejemplo de una función para calcular un color de contraste legible
    function calcularColorContraste(hexColor) {
        // Elimina el # si existe
        hexColor = hexColor.startsWith('#') ? hexColor.slice(1) : hexColor;

        // Convierte el color hexadecimal a RGB
        const r = parseInt(hexColor.substring(0, 2), 16);
        const g = parseInt(hexColor.substring(2, 4), 16);
        const b = parseInt(hexColor.substring(4, 6), 16);

        // Calcula el brillo (percepción humana del color)
        const brightness = (r * 299 + g * 587 + b * 114) / 1000;

        // Devuelve blanco o negro dependiendo del brillo
        return brightness > 128 ? '#000000' : '#ffffff';
    }
});