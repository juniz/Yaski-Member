<div>
    <!--  Tambah modal -->
    <div wire:ignore.self class="modal fade tambah-user" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <input class="form-control" type="text" wire:model='search' placeholder="Cari nama user .....">
                    </div>
                    <form class="form-horizontal" wire:submit.prevent='simpan' enctype="multipart/form-data">
                        @csrf
                        @forelse($users as $user)
                        <div class="form-check mb-3">
                            <input class="form-check-input" wire:key='{{$user->id}}' wire:model='selectedUser'
                                value="{{$user->id}}" type="checkbox" id="formCheck-{{$user->id}}">
                            <label class="form-check-label" for="formCheck-{{$user->id}}">
                                {{ $user->name }}
                            </label>
                            @error('selectedUser') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                        @empty
                        <li>Tidak ada user</li>
                        @endforelse

                        <div class="d-flex flex-row">
                            <div class="mx-auto">
                                {{ $users->links() }}
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