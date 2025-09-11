// user-menu.js
document.addEventListener('DOMContentLoaded', function () {
    // Función para mostrar/ocultar el menú de usuario
    function toggleUserMenu() {
        const dropdown = document.getElementById('userDropdown');
        if (dropdown) {
            dropdown.classList.toggle('hidden');
        }
    }

    // Función para cerrar sesión
    function logout() {
        const form = document.getElementById('logout-form');
        if (form) {
            form.submit();
        }
    }

    // Asignar evento al botón del menú
    const userMenuButton = document.querySelector('.user-menu-button');
    if (userMenuButton) {
        userMenuButton.addEventListener('click', function (e) {
            e.stopPropagation();
            toggleUserMenu();
        });
    }

    // Asignar evento al enlace de cerrar sesión
    const logoutLink = document.querySelector('.logout-link');
    if (logoutLink) {
        logoutLink.addEventListener('click', function (e) {
            e.preventDefault();
            logout();
        });
    }

    // Cerrar el menú al hacer clic fuera de él
    document.addEventListener('click', function (event) {
        const dropdown = document.getElementById('userDropdown');
        const button = document.querySelector('.user-menu-button');

        if (dropdown && button) {
            if (!dropdown.contains(event.target) && event.target !== button && !button.contains(event.target)) {
                dropdown.classList.add('hidden');
            }
        }
    });

    // Prevenir que el menú se cierre al hacer clic dentro de él
    const dropdown = document.getElementById('userDropdown');
    if (dropdown) {
        dropdown.addEventListener('click', function (event) {
            event.stopPropagation();
        });
    }
});