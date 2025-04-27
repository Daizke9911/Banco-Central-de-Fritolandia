document.addEventListener('DOMContentLoaded', function() {
    const passwordInput = document.getElementById('password');
    const passwordGroup = passwordInput.parentElement;

    // Crear el contenedor del icono
    const eyeIconContainer = document.createElement('div');
    eyeIconContainer.classList.add('eye-icon-container');
    eyeIconContainer.innerHTML = '<span class="eye-icon">&#128065;</span>'; // Unicode para un emoji de ojo
    passwordGroup.appendChild(eyeIconContainer);

    const eyeIcon = eyeIconContainer.querySelector('.eye-icon');

    eyeIconContainer.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            eyeIcon.textContent = '&#128064;'; // Unicode para un emoji de ojo tachado
        } else {
            passwordInput.type = 'password';
            eyeIcon.textContent = '&#128065;';
        }
    });

    // Estilos CSS adicionales para el icono
    const style = document.createElement('style');
    style.textContent = `
        .eye-icon-container {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            user-select: none;
        }
        .eye-icon {
            font-size: 18px;
            color: #777;
        }
    `;
    document.head.appendChild(style);
});