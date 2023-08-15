<div>
    <div class="card">
        <div class="card-header">
            <div class="d-flex flex-row justify-content-between">
                <h5 class="card-title mb-0">Team Members</h5>
                <button wire:click='openModal' class="btn btn-sm btn-secondary"><i class="bx bx-plus me-1"></i> Tambah
                </button>
                <button wire:click='getTeam' class="btn btn-sm btn-secondary"><i class="bx bx-plus me-1"></i> Refresh
                </button>
            </div>

        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table align-middle table-nowrap">
                    <tbody>
                        @foreach ($members as $subUser)
                        <tr>

                            <td style="width: 50px;"><img src="{{ URL::asset('storage/'. $subUser->avatar) }}"
                                    class="rounded-circle avatar-sm" alt=""></td>
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
                                    <button wire:click='editTeam("{{$subUser->id}}")' type="button"
                                        class="btn btn-sm btn-secondary"><i class="bx bx-edit "></i></button>
                                    <button wire:click='deleteTeam("{{$subUser->id}}")' id="sa-warning" type="button"
                                        class="btn btn-sm btn-danger"><i class="bx bx-trash "></i></button>
                                </div>
                            </td>
                        </tr>
                        @endforeach

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
                            <label for="avatarTeam">Foto Profile</label>
                            <div class="input-group">
                                <input wire:model='avatar' type="file"
                                    class="form-control @error('avatarTeam') is-invalid @enderror" id="avatarTeam"
                                    name="avatarTeam" autofocus>
                            </div>
                            @error('avatar') <div class="invalid-feedback">{{ $message }}</div> @enderror
                            <div class="text-start mt-2">
                                @if($avatar)
                                <img src="{{ $modeEdit ? URL::asset('storage/'. $avatar) : $avatar->temporaryUrl() }}"
                                    alt="" class="rounded-circle avatar-lg">
                                @endif
                            </div>
                            <div class="text-danger" role="alert" id="avatarTeamError" data-ajax-feedback="avatarTeam">
                            </div>
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