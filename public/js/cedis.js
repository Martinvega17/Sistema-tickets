// Función para aplicar filtros en tiempo real
function aplicarFiltros() {
    const searchValue = document.querySelector('input[name="search"]').value.toLowerCase();
    const regionValue = document.querySelector('select[name="region"]').value;
    const estatusValue = document.querySelector('select[name="estatus"]').value;

    const filasCedis = document.querySelectorAll('.cedis-row');
    let resultadosVisibles = 0;

    filasCedis.forEach(fila => {
        const nombre = fila.getAttribute('data-nombre').toLowerCase();
        const regionId = fila.getAttribute('data-region');
        const estatus = fila.getAttribute('data-estatus');
        const ingeniero = fila.getAttribute('data-ingeniero').toLowerCase();

        const coincideBusqueda = searchValue === '' ||
            nombre.includes(searchValue) ||
            ingeniero.includes(searchValue);
        const coincideRegion = regionValue === '' || regionId === regionValue;
        const coincideEstatus = estatusValue === '' || estatus === estatusValue;

        if (coincideBusqueda && coincideRegion && coincideEstatus) {
            fila.style.display = '';
            resultadosVisibles++;
        } else {
            fila.style.display = 'none';
        }
    });

    // Actualizar contador de resultados
    document.getElementById('resultadosContador').textContent =
        `Mostrando ${resultadosVisibles} de ${filasCedis.length} CEDIS`;
}

// Inicializar cuando el DOM esté listo
document.addEventListener('DOMContentLoaded', function () {
    // Configurar event listeners para los filtros
    const searchInput = document.querySelector('input[name="search"]');
    const regionSelect = document.querySelector('select[name="region"]');
    const estatusSelect = document.querySelector('select[name="estatus"]');

    if (searchInput) {
        searchInput.addEventListener('input', aplicarFiltros);
    }

    if (regionSelect) {
        regionSelect.addEventListener('change', aplicarFiltros);
    }

    if (estatusSelect) {
        estatusSelect.addEventListener('change', aplicarFiltros);
    }

    // Aplicar filtros iniciales
    aplicarFiltros();
});

// Funciones básicas para modales (si las necesitas)
function openDeleteModal(cedisId, cedisName) {
    document.getElementById('deleteCedisName').textContent = cedisName;
    const modal = document.getElementById('deleteCedisModal');
    modal.setAttribute('data-cedis-id', cedisId);
    modal.classList.remove('hidden');
}

function closeModal(modalId) {
    document.getElementById(modalId).classList.add('hidden');
}

// FiltroCedis.js - Filtrado en tiempo real para CEDIS

// FiltroCedis.js - Filtrado en tiempo real para CEDIS

class FiltroCedis {
    constructor() {
        this.cedisData = [];
        this.init();
    }

    init() {
        this.recopilarDatos();
        this.configurarEventListeners();
        this.configurarEventosDesactivacion();
        console.log('Filtro CEDIS inicializado');
    }

    recopilarDatos() {
        const filas = document.querySelectorAll('#tablaCedis tr');
        this.cedisData = [];

        filas.forEach(fila => {
            const cedi = {
                html: fila.outerHTML,
                id: fila.querySelector('button[onclick*="openDeleteModal"]')?.getAttribute('onclick')?.match(/\d+/)?.[0] || '',
                nombre: fila.cells[0].textContent.trim(),
                ingeniero: fila.cells[1].textContent.trim(),
                region: fila.cells[2].textContent.trim(),
                estatus: fila.cells[3].textContent.trim().toLowerCase()
            };
            this.cedisData.push(cedi);
        });
    }

    configurarEventListeners() {
        const searchInput = document.getElementById('searchInput');
        const regionSelect = document.getElementById('regionSelect');
        const estatusSelect = document.getElementById('estatusSelect');

        if (searchInput) searchInput.addEventListener('input', () => this.aplicarFiltros());
        if (regionSelect) regionSelect.addEventListener('change', () => this.aplicarFiltros());
        if (estatusSelect) estatusSelect.addEventListener('change', () => this.aplicarFiltros());
    }

    configurarEventosDesactivacion() {
        document.addEventListener('click', (e) => {
            if (e.target.closest('.toggle-status-btn')) {
                e.preventDefault();
                const button = e.target.closest('.toggle-status-btn');
                const cedisId = button.getAttribute('data-id');
                const cedisNombre = button.getAttribute('data-nombre');
                const accion = button.getAttribute('data-accion');

                this.cambiarEstatus(cedisId, cedisNombre, accion);
            }
        });
    }

    async cambiarEstatus(cedisId, cedisNombre, accion) {
        const nuevoEstatus = accion === 'desactivar' ? 'inactivo' : 'activo';

        if (!confirm(`¿Estás seguro que quieres ${accion} el CEDIS "${cedisNombre}"?`)) {
            return;
        }

        try {
            const response = await fetch(`/cedis/${cedisId}/toggle-status`, {
                method: 'PUT', // Cambiado a PUT
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                    'X-Requested-With': 'XMLHttpRequest'
                },
                body: JSON.stringify({ estatus: nuevoEstatus })
            });

            const data = await response.json();

            if (response.ok) {
                alert(data.message || `CEDIS ${accion === 'desactivar' ? 'desactivado' : 'activado'} correctamente`);
                window.location.reload();
            } else {
                throw new Error(data.error || 'Error al cambiar el estatus');
            }
        } catch (error) {
            console.error('Error:', error);
            alert('Error: ' + error.message);
        }
    }

    aplicarFiltros() {
        const searchValue = document.getElementById('searchInput').value.toLowerCase();
        const regionValue = document.getElementById('regionSelect').value;
        const estatusValue = document.getElementById('estatusSelect').value;

        const resultadosFiltrados = this.cedisData.filter(cedi => {
            const coincideBusqueda = searchValue === '' ||
                cedi.nombre.toLowerCase().includes(searchValue) ||
                cedi.ingeniero.toLowerCase().includes(searchValue);

            const coincideRegion = regionValue === '' || cedi.region.includes(regionValue);
            const coincideEstatus = estatusValue === '' || cedi.estatus.includes(estatusValue);

            return coincideBusqueda && coincideRegion && coincideEstatus;
        });

        this.actualizarTabla(resultadosFiltrados);
        this.actualizarContador(resultadosFiltrados.length);
    }

    actualizarTabla(resultados) {
        const tablaBody = document.getElementById('tablaCedis');
        if (tablaBody) {
            tablaBody.innerHTML = resultados.map(cedi => cedi.html).join('');
        }
    }

    actualizarContador(cantidad) {
        const contador = document.getElementById('contadorActual');
        if (contador) {
            contador.textContent = cantidad;
        }
    }

    limpiarFiltros() {
        document.getElementById('searchInput').value = '';
        document.getElementById('regionSelect').value = '';
        document.getElementById('estatusSelect').value = '';
        this.aplicarFiltros();
    }
}

// Inicializar
document.addEventListener('DOMContentLoaded', function () {
    window.filtroCedis = new FiltroCedis();
});

// Funciones globales
function limpiarFiltros() {
    if (window.filtroCedis) {
        window.filtroCedis.limpiarFiltros();
    }
}

function openDeleteModal(cedisId, cedisName) {
    const modalName = document.getElementById('deleteCedisName');
    const modal = document.getElementById('deleteCedisModal');

    if (modalName && modal) {
        modalName.textContent = cedisName;
        modal.setAttribute('data-cedis-id', cedisId);
        modal.classList.remove('hidden');
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    if (modal) {
        modal.classList.add('hidden');
    }
}