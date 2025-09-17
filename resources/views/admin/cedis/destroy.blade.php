<div class="modal fade fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden"
    id="deleteCedisModal">
    <div class="modal-dialog relative top-20 mx-auto p-4 border w-full max-w-md shadow-lg rounded-md bg-white">
        <div class="modal-content rounded-xl border-0 shadow-xl">
            <!-- Header del Modal -->
            <div class="modal-header bg-red-600 text-white rounded-t-xl p-6">
                <h5 class="modal-title text-xl font-bold">Confirmar Eliminación</h5>
                <button type="button" class="text-white close-modal" data-modal="deleteCedisModal">
                    <i class="bi bi-x-lg text-xl"></i>
                </button>
            </div>

            <!-- Contenido del Modal -->
            <div class="modal-body p-6 bg-gray-50">
                <div class="text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100 mb-4">
                        <i class="bi bi-exclamation-triangle text-red-600 text-2xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mb-2" id="deleteCedisTitle">¿Estás seguro?</h3>
                    <p class="text-sm text-gray-500 mb-4">
                        Esta acción eliminará permanentemente el CEDIS "<span id="deleteCedisName"
                            class="font-semibold"></span>".
                        Esta acción no se puede deshacer.
                    </p>
                    <p class="text-sm text-red-600 hidden" id="deleteCedisError"></p>
                </div>
            </div>

            <!-- Footer del Modal -->
            <div class="modal-footer bg-white rounded-b-xl p-6 border-t border-gray-200 flex justify-end space-x-3">
                <button type="button"
                    class="px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition duration-150 close-modal"
                    data-modal="deleteCedisModal">
                    Cancelar
                </button>
                <button type="button" id="confirmDeleteCedis"
                    class="px-4 py-2 bg-G-600 text-white rounded-lg hover:bg-red-700 transition duration-150">
                    <i class="bi bi-trash mr-2"></i> Eliminar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    let currentCedisId = null;
    let currentCedisName = null;

    // Función para abrir el modal de eliminación
    function openDeleteModal(cedisId, cedisName) {
        currentCedisId = cedisId;
        currentCedisName = cedisName;

        document.getElementById('deleteCedisName').textContent = cedisName;
        document.getElementById('deleteCedisError').classList.add('hidden');
        document.getElementById('deleteCedisError').textContent = '';

        document.getElementById('deleteCedisModal').classList.remove('hidden');
    }

    // Función para cerrar modales
    function closeModal(modalId) {
        document.getElementById(modalId).classList.add('hidden');
    }

    // Función para eliminar CEDIS
    async function deleteCedis() {
        if (!currentCedisId) return;

        try {
            const response = await fetch(`/cedis/${currentCedisId}`, {
                method: 'DELETE',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });

            const data = await response.json();

            if (!response.ok) {
                throw new Error(data.error || `Error HTTP: ${response.status}`);
            }

            alert(data.message || 'CEDIS eliminado correctamente');
            closeModal('deleteCedisModal');

            // Recargar la tabla
            if (typeof loadCedis === 'function') {
                loadCedis();
            } else {
                window.location.reload();
            }

        } catch (error) {
            console.error('Error al eliminar CEDIS:', error);
            const errorElement = document.getElementById('deleteCedisError');
            errorElement.textContent = 'Error: ' + error.message;
            errorElement.classList.remove('hidden');
        }
    }

    // Event listeners
    document.addEventListener('DOMContentLoaded', function() {
        // Botón de confirmación
        document.getElementById('confirmDeleteCedis').addEventListener('click', deleteCedis);

        // Cerrar modal al hacer clic fuera
        document.getElementById('deleteCedisModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal('deleteCedisModal');
            }
        });

        // Cerrar modal con botones
        document.querySelectorAll('.close-modal').forEach(button => {
            button.addEventListener('click', function() {
                const modalId = this.getAttribute('data-modal');
                closeModal(modalId);
            });
        });

        // Cerrar con ESC
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                closeModal('deleteCedisModal');
            }
        });
    });
</script>

<style>
    .modal {
        transition: opacity 0.3s ease;
    }

    .modal.hidden {
        opacity: 0;
        pointer-events: none;
    }

    .modal:not(.hidden) {
        opacity: 1;
    }
</style>
