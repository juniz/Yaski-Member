<div>
    <!--  Tambah modal -->
    <div wire:ignore.self class="modal fade edit-user" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" wire:submit.prevent='simpan' enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input wire:model.defer='name' type="text"
                                class="form-control @error('name') is-invalid @enderror" autofocus>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input wire:model.defer='email' type="text"
                                class="form-control @error('email') is-invalid @enderror" autofocus>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="form-check mb-3">
                            <label for="verif_email" class="form-check-label">Verifikasi Email</label>
                            <input type="checkbox" wire:model='verifEmail' class="form-check-input" name="verif_email" id="verif_email">
                        </div>
                        <div class="mb-3">
                            <label for="role" class="form-label">Role</label>
                            <select wire:model.defer='roleUser' class="form-select @error('role') is-invalid @enderror"
                                autofocus>
                                <option value="">Pilih Role</option>
                                @foreach($roles as $role)
                                <option wire:key='{{$role->id}}' value="{{ $role->id }}">{{
                                    $role->name }}</option>
                                @endforeach
                            </select>
                            @error('role') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        <div class="mb-3">
                            <label for="avatarTeam">Foto Profile</label>
                            <div class="input-group">
                                <input wire:model='avatar' type="file"
                                    class="form-control @error('avatarTeam') is-invalid @enderror" id="avatarTeam"
                                    name="avatarTeam" accept="image/*" autofocus>
                            </div>
                            @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="text-start mt-2">
                                @if($avatar)
                                <img src="{{ URL::asset('storage/'. $avatar) }}" alt=""
                                    class="rounded-circle avatar-lg">
                                @endif
                            </div>
                        </div>


                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light" type="submit">Tambahkan</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>