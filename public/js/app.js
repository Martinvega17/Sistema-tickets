console.log('🔴 SCRIPT INLINE EJECUTADO');

function inicializarCedis() {
    console.log('🟢 inicializarCedis llamado');

    const region = document.querySelector('select[name="region_id"]');
    const cedis = document.querySelector('select[name="cedis_id"]');

    console.log('Elementos querySelector:', {
        region,
        cedis
    });

    if (!region || !cedis) {
        console.log('⏳ Reintentando en 500ms...');
        setTimeout(inicializarCedis, 500);
        return;
    }

    console.log('✅ ELEMENTOS ENCONTRADOS CON QUERYSELECTOR');

    region.onchange = function () {
        console.log('🎯 ONCHANGE - Valor:', this.value);

        cedis.innerHTML = '<option value="">Cargando...</option>';
        cedis.disabled = true;

        fetch(`/get-cedis-by-region?region_id=${this.value}`)
            .then(r => r.json())
            .then(data => {
                console.log('CEDIS data:', data);
                cedis.innerHTML = '<option value="">Selecciona CEDIS</option>';
                data.forEach(item => {
                    cedis.innerHTML += `<option value="${item.id}">${item.nombre}</option>`;
                });
                cedis.disabled = false;
            });
    };

    // Trigger inicial
    if (region.value) {
        console.log('🔥 DISPARANDO EVENTO INICIAL');
        region.onchange();
    }
}

// Múltiples formas de inicializar
document.addEventListener('DOMContentLoaded', inicializarCedis);
window.addEventListener('load', inicializarCedis);
setTimeout(inicializarCedis, 1000);

// También exponer la función globalmente por si acaso
window.cargarCedisManual = function () {
    const region = document.querySelector('select[name="region_id"]');
    if (region && region.value) {
        console.log('🔧 CARGA MANUAL con región:', region.value);
        region.onchange();
    } else {
        alert('Selecciona una región primero');
    }
};