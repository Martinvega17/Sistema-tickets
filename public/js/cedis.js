// Variables globales
let currentPage = 1;
const itemsPerPage = 10;
let allCedis = [];
let filteredCedis = [];
let regions = [];

// Función segura para obtener el token CSRF
function getCsrfToken() {
    const metaTag = document.querySelector('meta[name="csrf-token"]');
    if (metaTag) {
        return metaTag.content;
    }
    console.error('CSRF token meta tag not found');
    return '';
}

// Cargar regiones desde la API
async function loadRegions() {
    try {
        const response = await fetch('/api/regiones');
        regions = await response.json();
        fillRegionSelectors(regions);
    } catch (error) {
        console.error('Error al cargar las regiones:', error);
    }
}

// Llenar selectores de regiones (solo para el filtro en index)
function fillRegionSelectors(regions) {
    const selector = document.getElementById('regionFilter');
    if (selector) {
        selector.innerHTML = '<option value="">Todas las regiones</option>' +
            regions.map(region =>
                `<option value="${region.id}">${region.nombre}</option>`
            ).join('');
    }
}

// Función para redirigir a la vista de edición
function editCedis(cedisId) {
    window.location.href = `/cedis/${cedisId}/edit`;
}

// Función para abrir modal de eliminación
function openDeleteModal(cedisId, cedisName) {
    // Establecer los valores en el modal
    document.getElementById('deleteCedisName').textContent = cedisName;
    document.getElementById('deleteCedisError').classList.add('hidden');
    document.getElementById('deleteCedisError').textContent = '';

    // Almacenar el ID del CEDIS en un data attribute
    const modal = document.getElementById('deleteCedisModal');
    modal.setAttribute('data-cedis-id', cedisId);

    // Mostrar el modal
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

        // Recargar la tabla
        loadCedis();

    } catch (error) {
        console.error('Error al eliminar CEDIS:', error);
        const errorElement = document.getElementById('deleteCedisError');
        errorElement.textContent = 'Error: ' + error.message;
        errorElement.classList.remove('hidden');
    }
}

// Mostrar loading
function showLoading() {
    const tbody = document.getElementById('cedisTableBody');
    if (tbody) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-4 text-center">
                    <div class="flex justify-center items-center">
                        <div class="loading mr-2"></div>
                        Cargando CEDIS...
                    </div>
                </td>
            </tr>
        `;
    }
}

// Renderizar la tabla de CEDIS
function renderCedisTable() {
    const tbody = document.getElementById('cedisTableBody');
    if (!tbody) return;

    if (filteredCedis.length === 0) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-gray-500">
                    No se encontraron CEDIS que coincidan con los criterios de búsqueda.
                </td>
            </tr>
        `;
        return;
    }

    const startIndex = (currentPage - 1) * itemsPerPage;
    const endIndex = Math.min(startIndex + itemsPerPage, filteredCedis.length);
    const currentCedis = filteredCedis.slice(startIndex, endIndex);

    tbody.innerHTML = currentCedis.map(cedis => `
        <tr>
            <td class="px-6 py-4 whitespace-nowrap">${cedis.nombre}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="text-gray-400">
                    ${cedis.ingeniero ? `${cedis.ingeniero.nombre} ${cedis.ingeniero.apellido}` : 'Sin asignar'}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap">${cedis.region ? cedis.region.nombre : 'N/A'}</td>
            <td class="px-6 py-4 whitespace-nowrap">
                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full ${cedis.estatus === 'activo' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800'}">
                    ${cedis.estatus === 'activo' ? 'Activo' : 'Inactivo'}
                </span>
            </td>
            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                <button onclick="editCedis(${cedis.id})" class="text-blue-600 hover:text-blue-900 mr-3">
                    <i class="bi bi-pencil-square"></i> Editar
                </button>
                <button onclick="toggleStatus(${cedis.id}, '${cedis.estatus}')" 
                        class="${cedis.estatus === 'activo' ? 'text-red-600 hover:text-red-900' : 'text-green-600 hover:text-green-900'} mr-3">
                    <i class="bi ${cedis.estatus === 'activo' ? 'bi-x-circle' : 'bi-check-circle'}"></i> 
                    ${cedis.estatus === 'activo' ? 'Desactivar' : 'Activar'}
                </button>
                <button onclick="openDeleteModal(${cedis.id}, '${cedis.nombre.replace(/'/g, "\\'")}')" 
                        class="text-green-600 hover:text-green-900">
                    <i class="bi bi-trash"></i> Eliminar
                </button>
            </td>
        </tr>
    `).join('');
}

// Actualizar la paginación
function updatePagination() {
    const paginationInfo = document.getElementById('paginationInfo');
    const paginationNav = document.getElementById('paginationNav');

    if (!paginationInfo || !paginationNav) return;

    const totalPages = Math.ceil(filteredCedis.length / itemsPerPage);
    const startItem = (currentPage - 1) * itemsPerPage + 1;
    const endItem = Math.min(currentPage * itemsPerPage, filteredCedis.length);

    paginationInfo.innerHTML = `
        Mostrando
        <span class="font-medium">${startItem}</span>
        a
        <span class="font-medium">${endItem}</span>
        de
        <span class="font-medium">${filteredCedis.length}</span>
        resultados
    `;

    let paginationHTML = '';

    // Botón anterior
    paginationHTML += currentPage > 1 ? `
        <a href="#" onclick="changePage(${currentPage - 1}); return false;" class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
            <span class="sr-only">Anterior</span>
            <i class="bi bi-chevron-left"></i>
        </a>
    ` : `
        <span class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400">
            <i class="bi bi-chevron-left"></i>
        </span>
    `;

    // Números de página
    const maxVisiblePages = 5;
    let startPage = Math.max(1, currentPage - Math.floor(maxVisiblePages / 2));
    let endPage = Math.min(totalPages, startPage + maxVisiblePages - 1);

    if (endPage - startPage + 1 < maxVisiblePages) {
        startPage = Math.max(1, endPage - maxVisiblePages + 1);
    }

    for (let i = startPage; i <= endPage; i++) {
        paginationHTML += i === currentPage ? `
            <span class="relative inline-flex items-center px-4 py-2 border border-pepsi-blue bg-pepsi-blue text-sm font-medium text-white">
                ${i}
            </span>
        ` : `
            <a href="#" onclick="changePage(${i}); return false;" class="relative inline-flex items-center px-4 py-2 border border-gray-300 bg-white text-sm font-medium text-gray-700 hover:bg-gray-50">
                ${i}
            </a>
        `;
    }

    // Botón siguiente
    paginationHTML += currentPage < totalPages ? `
        <a href="#" onclick="changePage(${currentPage + 1}); return false;" class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50">
            <span class="sr-only">Siguiente</span>
            <i class="bi bi-chevron-right"></i>
        </a>
    ` : `
        <span class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-gray-100 text-sm font-medium text-gray-400">
            <i class="bi bi-chevron-right"></i>
        </span>
    `;

    paginationNav.innerHTML = paginationHTML;
}

// Cambiar de página
function changePage(page) {
    currentPage = page;
    renderCedisTable();
    updatePagination();
}

// Filtrar CEDIS
function filterCedis() {
    const searchInput = document.querySelector('input[name="search"]');
    const regionSelect = document.getElementById('regionFilter');
    const statusSelect = document.querySelector('select[name="estatus"]');

    if (!searchInput || !regionSelect || !statusSelect) return;

    const searchTerm = searchInput.value.toLowerCase();
    const regionId = regionSelect.value;
    const status = statusSelect.value;

    filteredCedis = allCedis.filter(cedis => {
        const matchesSearch = cedis.nombre.toLowerCase().includes(searchTerm) ||
            (cedis.codigo && cedis.codigo.toLowerCase().includes(searchTerm));
        const matchesRegion = !regionId || cedis.region_id == regionId;
        const matchesStatus = !status || cedis.estatus === status;

        return matchesSearch && matchesRegion && matchesStatus;
    });

    currentPage = 1;
    renderCedisTable();
    updatePagination();
}

// Cambiar estatus del CEDIS
async function toggleStatus(cedisId, currentStatus) {
    if (confirm(`¿Estás seguro de ${currentStatus === 'activo' ? 'desactivar' : 'activar'} este CEDIS?`)) {
        try {
            const newStatus = currentStatus === 'activo' ? 'inactivo' : 'activo';

            const response = await fetch(`/cedis/${cedisId}/estatus`, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': getCsrfToken()
                },
                body: JSON.stringify({ estatus: newStatus })
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.message || `Error HTTP: ${response.status}`);
            }

            const result = await response.json();
            alert(result.message || 'Estatus actualizado correctamente');

            // Recargar la tabla
            loadCedis();

        } catch (error) {
            console.error('Error al cambiar estatus:', error);
            alert('Error al cambiar el estatus del CEDIS: ' + error.message);
        }
    }
}

// Cargar CEDIS desde la API
async function loadCedis() {
    try {
        showLoading();

        const response = await fetch('/cedis/data');

        if (!response.ok) {
            throw new Error(`Error HTTP: ${response.status}`);
        }

        const data = await response.json();
        allCedis = data;
        filteredCedis = [...allCedis];

        renderCedisTable();
        updatePagination();

    } catch (error) {
        console.error('Error al cargar los CEDIS:', error);
        showError('Error al cargar los CEDIS: ' + error.message);
    }
}

// Mostrar error
function showError(message) {
    const tbody = document.getElementById('cedisTableBody');
    if (tbody) {
        tbody.innerHTML = `
            <tr>
                <td colspan="5" class="px-6 py-4 text-center text-red-600">
                    ${message}
                </td>
            </tr>
        `;
    }
}

// Inicializar la aplicación
function initApp() {
    // Solo inicializar si estamos en la página index
    const cedisTable = document.getElementById('cedisTableBody');
    if (!cedisTable) return;

    loadRegions();
    loadCedis();

    // Event listener para el formulario de búsqueda
    const searchForm = document.getElementById('searchForm');
    if (searchForm) {
        searchForm.addEventListener('submit', function (e) {
            e.preventDefault();
            filterCedis();
        });
    }

    // Event listeners para los filtros
    const regionFilter = document.getElementById('regionFilter');
    if (regionFilter) {
        regionFilter.addEventListener('change', filterCedis);
    }

    const statusFilter = document.querySelector('select[name="estatus"]');
    if (statusFilter) {
        statusFilter.addEventListener('change', filterCedis);
    }

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
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', initApp);