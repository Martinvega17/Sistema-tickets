// public/js/register.js
document.addEventListener('DOMContentLoaded', function () {
    const regionSelect = document.getElementById('region_id');
    const cedisSelect = document.getElementById('cedis_id');
    let cedisData = {};

    // Cargar todos los CEDIS
    fetch('/get-cedis')
        .then(response => response.json())
        .then(cedis => {
            // Organizar CEDIS por región
            cedisData = cedis.reduce((acc, item) => {
                if (!acc[item.region_id]) {
                    acc[item.region_id] = [];
                }
                acc[item.region_id].push(item);
                return acc;
            }, {});

            // Si hay región seleccionada, cargar sus CEDIS
            if (regionSelect.value) {
                cargarCedisPorRegion(regionSelect.value);
            }
        })
        .catch(error => {
            console.error('Error:', error);
        });

    // Función para cargar CEDIS por región
    function cargarCedisPorRegion(regionId) {
        cedisSelect.innerHTML = '<option value="">Selecciona un CEDIS</option>';

        if (!regionId || !cedisData) return;

        const cedisDeRegion = cedisData[regionId];

        if (cedisDeRegion && cedisDeRegion.length > 0) {
            cedisDeRegion.forEach(cedis => {
                const option = document.createElement('option');
                option.value = cedis.id;
                option.textContent = cedis.nombre;
                cedisSelect.appendChild(option);
            });

            // Seleccionar CEDIS anterior si existe (usando dataset)
            const oldCedisId = cedisSelect.dataset.old;
            if (oldCedisId) {
                cedisSelect.value = oldCedisId;
            }
        }
    }

    // Event listener para cambio de región
    regionSelect.addEventListener('change', function () {
        cargarCedisPorRegion(this.value);
    });
});