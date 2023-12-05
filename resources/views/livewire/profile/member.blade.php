<div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-row justify-content-between">
                <h5 class="card-title mb-0">Data PIC SIMKES</h5>
                <button wire:click='openModal' class="btn btn-sm btn-secondary"><i class="bx bx-plus me-1"></i> Tambah
                </button>
            </div>

        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-nowrap">
                    <tbody>
                        @forelse ($members as $subUser)
                        <tr>

                            <td style="width: 50px;">@if(empty($subUser->avatar)) <img
                                    src="{{ URL::asset('storage/avatar/blank.png') }}" class="rounded-circle avatar-sm"
                                    alt=""> @else <img src="{{ URL::asset('storage/teams/'. $subUser->avatar) }}"
                                    class="rounded-circle avatar-sm" alt="">@endif</td>
                            <td>
                                <h5 class="font-size-12 m-0"><a href="javascript: void(0);" class="text-dark">{{
                                        $subUser->name }}</a></h5>
                            </td>
                            <td>
                                <h5 class="font-size-12 text-mute m-0"><a href="javascript: void(0);"
                                        class="text-dark">{{
                                        $subUser->email }}</a></h5>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <button wire:key='{{$subUser->id}}' wire:click='editTeam("{{$subUser->id}}")'
                                        type="button" class="btn btn-sm btn-secondary"><i
                                            class="bx bx-edit "></i></button>
                                    <button wire:key='{{$subUser->id}}' wire:click='confirmDelete("{{$subUser->id}}")'
                                        id="sa-warning" type="button" class="btn btn-sm btn-danger"><i
                                            class="bx bx-trash "></i></button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">Data PIC Masih Kosong</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!--  Tambah team modal -->
    <div wire:ignore.self class="modal fade tambah-team" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myLargeModalLabel">Team</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" wire:submit.prevent='simpanMember' enctype="multipart/form-data"
                        id="tambah-team">
                        @csrf
                        <input type="hidden" value="{{ Auth::user()->id }}" id="data_id">
                        <div class="mb-3">
                            <label for="name" class="form-label">Nama</label>
                            <input wire:model.defer='name' type="text"
                                class="form-control @error('name') is-invalid @enderror" id="nameTeam" value=""
                                name="nameTeam" placeholder="Masukkan Nama" autofocus>
                            @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="useremail" class="form-label">Email</label>
                            <input wire:model.defer='email' type="email"
                                class="form-control @error('email') is-invalid @enderror" id="emailTeam" value=""
                                name="emailTeam" placeholder="Masukkan Email" autofocus>
                            @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telegram" class="form-label">Username Telegram</label>
                            <input wire:model.defer='telegram' type="text"
                                class="form-control @error('telegram') is-invalid @enderror" id="telegram"
                                name="telegram" placeholder="Masukkan Username Telegram" autofocus>
                            @error('telegram') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="telp" class="form-label">No. Telp</label>
                            <input wire:model.defer='telp' type="text"
                                class="form-control @error('email') is-invalid @enderror" id="telp"
                                name="telp" placeholder="Masukkan No. Telp" autofocus>
                            @error('telp') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>


                        <div class="mb-3">
                            <label for="avatarTeam">Foto PIC</label>
                            <div class="input-group">
                                <input wire:model='avatar' type="file"
                                    class="form-control @error('avatarTeam') is-invalid @enderror" id="avatarTeam"
                                    name="avatarTeam" autofocus>
                            </div>

                            <div class="text-start mt-2">
                                @if($avatar)
                                <img src="{{ $modeEdit ? URL::asset('storage/teams/'. $avatar) : $avatar->temporaryUrl() }}"
                                    alt="" class="rounded-circle avatar-lg">
                                @endif
                            </div>
                            @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mt-3 d-grid">
                            <button class="btn btn-primary waves-effect waves-light TambahTeam"
                                data-id="{{ Auth::user()->id }}" type="submit">Tambahkan</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</div>