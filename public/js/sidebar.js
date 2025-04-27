document.addEventListener('DOMContentLoaded', function() {
    const menuLinks = document.querySelectorAll('.menu a');
    const dashboardSections = document.querySelectorAll('.dashboard-section');

    // Función para mostrar la sección activa y ocultar las demás
    function showSection(sectionId) {
        dashboardSections.forEach(section => {
            section.classList.remove('active');
        });
        document.getElementById(sectionId + '-section').classList.add('active');

        // Actualizar la clase 'active' en el menú
        menuLinks.forEach(link => {
            link.classList.remove('active');
            if (link.dataset.section === sectionId) {
                link.classList.add('active');
            }
        });
    }

    // Event listeners para los enlaces del menú
    menuLinks.forEach(link => {
        link.addEventListener('click', function(event) {
            event.preventDefault();
            const sectionId = this.dataset.section;
            showSection(sectionId);
        });
    });

    // Mostrar la sección de overview al cargar la página
    showSection('overview');

    // Ejemplo simulado de funcionalidad (podrías expandir esto)
    const logoutButton = document.querySelector('.logout-btn');
    if (logoutButton) {
        logoutButton.addEventListener('click', function() {
            alert('Cerrando sesión...');
            // Aquí iría la lógica real para cerrar sesión
        });
    }

    // Si incluyes Chart.js, podrías agregar aquí un ejemplo de gráfico simulado
    // const salesChartCanvas = document.getElementById('salesChart');
    // if (salesChartCanvas) {
    //     new Chart(salesChartCanvas, {
    //         type: 'bar',
    //         data: {
    //             labels: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun'],
    //             datasets: [{
    //                 label: 'Ventas',
    //                 data: [65, 59, 80, 81, 56, 55],
    //                 backgroundColor: 'rgba(0, 123, 255, 0.7)',
    //                 borderColor: 'rgba(0, 123, 255, 1)',
    //                 borderWidth: 1
    //             }]
    //         },
    //         options: {
    //             scales: {
    //                 y: {
    //                     beginAtZero: true
    //                 }
    //             }
    //         }
    //     });
    // }
});