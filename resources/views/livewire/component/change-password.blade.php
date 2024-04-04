<div>
    {{-- Change Password Modal --}}
    <div wire:ignore.self class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="changePasswordModalLabel">Rubah Password</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {{-- Change Password Form --}}
                    <form wire:submit.prevent="changePassword">
                        <div class="mb-3">
                            <label for="currentPassword" class="form-label">Password Sekarang</label>
                            <input type="password" class="form-control" id="currentPassword" wire:model.defer="currentPassword">
                            @error('currentPassword') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="newPassword" class="form-label">Password Baru</label>
                            <input type="password" class="form-control" id="newPassword" wire:model.defer="newPassword">
                            @error('newPassword') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="confirmPassword" class="form-label">Konfirmasi Password</label>
                            <input type="password" class="form-control" id="confirmPassword" wire:model.defer="confirmPassword">
                            @error('confirmPassword') <span class="text-danger">{{ $message }}</span> @enderror
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
