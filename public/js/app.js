document.addEventListener('DOMContentLoaded', function () {
    console.log('🎯 Inicializando carga dinámica...');

    // Elementos para CEDIS
    const regionSelect = document.querySelector('select[name="region_id"]');
    const cedisSelect = document.querySelector('select[name="cedis_id"]');

    // Elementos para Servicios
    const areaSelect = document.querySelector('select[name="area_id"]');
    const servicioSelect = document.querySelector('select[name="servicio_id"]');

    // Función para cargar CEDIS
    function cargarCedis(regionId) {
        if (!regionId) {
            cedisSelect.innerHTML = '<option value="">Primero seleccione una región</option>';
            return;
        }

        cedisSelect.innerHTML = '<option value="">Cargando CEDIS...</option>';
        cedisSelect.disabled = true;

        fetch(`/get-cedis-by-region?region_id=${regionId}`)
            .then(response => response.json())
            .then(data => {
                cedisSelect.innerHTML = '<option value="">Selecciona un CEDIS</option>';

                if (data.length > 0) {
                    data.forEach(cedis => {
                        const option = document.createElement('option');
                        option.value = cedis.id;
                        option.textContent = cedis.nombre;
                        cedisSelect.appendChild(option);
                    });
                } else {
                    cedisSelect.innerHTML = '<option value="">No hay CEDIS disponibles</option>';
                }

                cedisSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error al cargar CEDIS:', error);
                cedisSelect.innerHTML = '<option value="">Error al cargar CEDIS</option>';
                cedisSelect.disabled = false;
            });
    }

    // Función para cargar Servicios
    function cargarServicios(areaId) {
        if (!areaId) {
            servicioSelect.innerHTML = '<option value="">Primero seleccione un área</option>';
            return;
        }

        servicioSelect.innerHTML = '<option value="">Cargando servicios...</option>';
        servicioSelect.disabled = true;

        fetch(`/api/servicios/${areaId}`)
            .then(response => response.json())
            .then(data => {
                servicioSelect.innerHTML = '<option value="">Selecciona un servicio</option>';

                if (data.length > 0) {
                    data.forEach(servicio => {
                        const option = document.createElement('option');
                        option.value = servicio.id;
                        option.textContent = servicio.nombre;
                        servicioSelect.appendChild(option);
                    });
                } else {
                    servicioSelect.innerHTML = '<option value="">No hay servicios disponibles</option>';
                }

                servicioSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error al cargar servicios:', error);
                servicioSelect.innerHTML = '<option value="">Error al cargar servicios</option>';
                servicioSelect.disabled = false;
            });
    }

    // Event listeners para Región -> CEDIS
    if (regionSelect && cedisSelect) {
        regionSelect.addEventListener('change', function () {
            console.log('🔄 Cambio de región:', this.value);
            cargarCedis(this.value);
        });

        // Cargar CEDIS si ya hay una región seleccionada
        if (regionSelect.value) {
            cargarCedis(regionSelect.value);
        }
    }

    // Event listeners para Área -> Servicios
    if (areaSelect && servicioSelect) {
        areaSelect.addEventListener('change', function () {
            console.log('🔄 Cambio de área:', this.value);
            cargarServicios(this.value);
        });

        // Cargar Servicios si ya hay un área seleccionada
        if (areaSelect.value) {
            cargarServicios(areaSelect.value);
        }
    }

    console.log('✅ Sistema de carga dinámica configurado');
});