<div>
    <!--  Tambah team modal -->
    <div wire:ignore.self class="modal fade edit-team-modal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">PIC SIMKES</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" wire:submit.prevent='edit'>
                        <div class="mb-3">
                            <label for="name" class="form-label required">Nama</label>
                            <input wire:model.defer='name' type="text"
                                class="form-control uppercase @error('name') is-invalid @enderror" id="edit-name" value=""
                                name="edit-name" autofocus>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="useremail" class="form-label required">Email</label>
                            <input wire:model.defer='email' type="email"
                                class="form-control lowercase @error('email') is-invalid @enderror" id="edit-email" value=""
                                name="edit-email" placeholder="Masukkan Email" autofocus>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telegram" class="form-label required">Username Telegram</label>
                            <input wire:model.defer='telegram' type="text"
                                class="form-control @error('telegram') is-invalid @enderror" id="edit-telegram"
                                name="edit-telegram" placeholder="Masukkan Username Telegram" autofocus>
                            @error('telegram') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telp" class="form-label required">No. Telp</label>
                            <input wire:model.defer='telp' type="text"
                                class="form-control @error('email') is-invalid @enderror" id="edit-telp"
                                name="edit-telp" placeholder="Masukkan No. Telp" autofocus>
                            @error('telp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>


                        <div class="mb-3">
                            <label for="avatarTeam" class="required">Foto PIC</label>
                            <div class="input-group">
                                <input wire:model='avatar' type="file"
                                    class="form-control @error('avatarTeam') is-invalid @enderror" id="edit-avatar"
                                    name="edit-avatar" autofocus>
                            </div>
                            @error('avatar') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="sk_pic" class="required">SK PIC</label>
                            <div class="input-group">
                                <input wire:model='sk_pic' type="file"
                                    class="form-control @error('sk_pic') is-invalid @enderror" id="edit-sk_pic"
                                    name="edit-sk_pic" autofocus>
                            </div>
                            @error('sk_pic') <small class="text-danger">{{ $message }}</small> @enderror
                        </div>
                        <small wire:loading>Loading...</small>
                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light TambahTeam" wire:loading.attr='disabled' type="submit">Ubah</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>
