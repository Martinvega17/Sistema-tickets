// Datos de los CEDIS para filtrar
const cedisData = window.cedisData || []; // Lo pasaremos desde Blade

function aplicarFiltros() {
    const searchValue = document.getElementById('searchInput').value.toLowerCase();
    const regionValue = document.getElementById('regionSelect').value;
    const estatusValue = document.getElementById('estatusSelect').value;

    const resultadosFiltrados = cedisData.filter(cedi => {
        const coincideBusqueda = searchValue === '' ||
            cedi.nombre.toLowerCase().includes(searchValue) ||
            cedi.ingeniero.toLowerCase().includes(searchValue);
        const coincideRegion = regionValue === '' || cedi.region_id == regionValue;
        const coincideEstatus = estatusValue === '' || cedi.estatus === estatusValue;

        return coincideBusqueda && coincideRegion && coincideEstatus;
    });

    // Actualizar tabla
    const tablaBody = document.getElementById('tablaCedis');
    tablaBody.innerHTML = resultadosFiltrados.map(cedi => cedi.html).join('');

    // Actualizar contador
    document.getElementById('contadorActual').textContent = resultadosFiltrados.length;
}

function limpiarFiltros() {
    document.getElementById('searchInput').value = '';
    document.getElementById('regionSelect').value = '';
    document.getElementById('estatusSelect').value = '';
    aplicarFiltros();
}

// Modales
function openDeleteModal(cedisId, cedisName) {
    if (document.getElementById('deleteCedisName')) {
        document.getElementById('deleteCedisName').textContent = cedisName;
    }
    if (document.getElementById('deleteCedisModal')) {
        const modal = document.getElementById('deleteCedisModal');
        modal.setAttribute('data-cedis-id', cedisId);
        modal.classList.remove('hidden');
    }
}

function closeModal(modalId) {
    if (document.getElementById(modalId)) {
        document.getElementById(modalId).classList.add('hidden');
    }
}

// Event listeners
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('searchInput').addEventListener('input', aplicarFiltros);
    document.getElementById('regionSelect').addEventListener('change', aplicarFiltros);
    document.getElementById('estatusSelect').addEventListener('change', aplicarFiltros);
});
