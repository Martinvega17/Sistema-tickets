<div class="modal fade" id="resetPasswordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Restablecer Contraseña</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="resetPasswordForm">
                <div class="modal-body">
                    <input type="hidden" id="reset_user_id" name="user_id">

                    <div class="mb-4">
                        <label class="form-label">Nueva Contraseña</label>
                        <input type="password" id="reset_password" name="password" class="form-control" required
                            minlength="8">
                    </div>

                    <div class="mb-4">
                        <label class="form-label">Confirmar Contraseña</label>
                        <input type="password" id="reset_password_confirmation" name="password_confirmation"
                            class="form-control" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="submit" class="btn btn-primary">Restablecer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('resetPasswordForm').addEventListener('submit', function(e) {
        e.preventDefault();

        const userId = document.getElementById('reset_user_id').value;
        const formData = new FormData(this);

        fetch(`/usuarios/${userId}/password`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert('Contraseña restablecida correctamente');
                    bootstrap.Modal.getInstance(document.getElementById('resetPasswordModal')).hide();
                } else if (data.errors) {
                    alert('Error: ' + Object.values(data.errors).join(', '));
                }
            });
    });
</script>
