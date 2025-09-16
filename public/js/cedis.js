// Variables globales
let allCedis = [];
let filteredCedis = [];

// Función segura para obtener el token CSRF
function getCsrfToken() {
    const metaTag = document.querySelector('meta[name="csrf-token"]');
    if (metaTag) {
        return metaTag.content;
    }
    console.error('CSRF token meta tag not found');
    return '';
}

// Función para redirigir a la vista de edición
function editCedis(cedisId) {
    window.location.href = `/cedis/${cedisId}/edit`;
}

// Función para abrir modal de eliminación
function openDeleteModal(cedisId, cedisName) {
    document.getElementById('deleteCedisName').textContent = cedisName;
    document.getElementById('deleteCedisError').classList.add('hidden');
    document.getElementById('deleteCedisError').textContent = '';

    const modal = document.getElementById('deleteCedisModal');
    modal.setAttribute('data-cedis-id', cedisId);
    modal.classList.remove('hidden');
}

// Función para cerrar modales
function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

// Función para eliminar CEDIS
async function confirmDeleteCedis() {
    const modal = document.getElementById('deleteCedisModal');
    const cedisId = modal.getAttribute('data-cedis-id');

    if (!cedisId) {
        console.error('No se encontró el ID del CEDIS');
        return;
    }

    try {
        const response = await fetch(`/cedis/${cedisId}`, {
            method: 'DELETE',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            }
        });

        const data = await response.json();

        if (!response.ok) {
            throw new Error(data.error || `Error HTTP: ${response.status}`);
        }

        alert(data.message || 'CEDIS eliminado correctamente');
        closeModal('deleteCedisModal');

        // Recargar la página
        window.location.reload();

    } catch (error) {
        console.error('Error al eliminar CEDIS:', error);
        const errorElement = document.getElementById('deleteCedisError');
        errorElement.textContent = 'Error: ' + error.message;
        errorElement.classList.remove('hidden');
    }
}

// Función para cambiar el estatus del CEDIS

// Función para cambiar el estatus del CEDIS
async function toggleStatus(id, currentStatus, nombre) {
    const newStatus = currentStatus === 'activo' ? 'inactivo' : 'activo';

    if (!confirm(`¿Estás seguro que quieres ${newStatus === 'activo' ? 'activar' : 'desactivar'} el CEDIS "${nombre}"?`)) {
        return;
    }

    console.log('Solicitando cambio de estatus:', {
        cedis_id: id,
        estatus_actual: currentStatus,
        estatus_nuevo: newStatus
    });

    try {
        const response = await fetch(`/cedis/${id}/toggle-status`, {
            method: 'PUT',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken()
            },
            body: JSON.stringify({ estatus: newStatus })
        });

        console.log('Respuesta del servidor:', {
            status: response.status,
            statusText: response.statusText
        });

        const data = await response.json();
        console.log('Datos de respuesta:', data);

        if (response.ok && data.estatus) {
            // Mostrar mensaje de éxito
            alert(`CEDIS ${newStatus === 'activo' ? 'activado' : 'desactivado'} correctamente`);

            // Recargar la página para ver los cambios
            window.location.reload();
        } else {
            throw new Error(data.error || 'Error al actualizar el estatus');
        }
    } catch (error) {
        console.error('Error al cambiar estatus:', error);
        alert('Error: ' + error.message);
    }
}

// Inicializar la aplicación
function initApp() {
    console.log('Inicializando aplicación CEDIS...');

    // Event listeners para el modal de eliminación
    const confirmDeleteBtn = document.getElementById('confirmDeleteCedis');
    if (confirmDeleteBtn) {
        confirmDeleteBtn.addEventListener('click', confirmDeleteCedis);
    }

    // Cerrar modal al hacer clic fuera
    const deleteModal = document.getElementById('deleteCedisModal');
    if (deleteModal) {
        deleteModal.addEventListener('click', function (e) {
            if (e.target === this) {
                closeModal('deleteCedisModal');
            }
        });
    }

    // Cerrar modal con botones
    document.querySelectorAll('.close-modal').forEach(button => {
        button.addEventListener('click', function () {
            const modalId = this.getAttribute('data-modal');
            closeModal(modalId);
        });
    });

    // Cerrar con ESC
    document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape') {
            closeModal('deleteCedisModal');
        }
    });

    // Configurar event listeners para los botones de toggle status
    document.querySelectorAll('.toggle-status').forEach(button => {
        button.addEventListener('click', function () {
            const id = this.getAttribute('data-id');
            const currentStatus = this.getAttribute('data-status');
            const nombre = this.getAttribute('data-nombre');

            toggleStatus(id, currentStatus, nombre);
        });
    });

    // Event listener para el formulario de búsqueda
    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', function (e) {
            e.preventDefault();
            // Enviar el formulario normalmente (recarga la página)
            this.submit();
        });
    }
}

// Inicializar cuando el DOM esté listo
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initApp);
} else {
    initApp();
}