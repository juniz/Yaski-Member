<div>
    <div class="d-flex flex-row-reverse" style="gap: 10px">
        <button type="button" wire:click='$emit("tambah")' class="btn btn-primary"><i
                class="bx bx-plus me-1"></i>Tambah</button>
        <div class="col-xs-3">
            <input type="text" placeholder="Cari....." wire:model.debounce.500ms='search' class="form-control">
        </div>
    </div>
    <div class="table-responsive mt-2">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Roles</th>
                    <th>Users</th>
                    <th>Permission</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($roles as $role)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $role->name }}</td>
                    <td>
                        @forelse($role->users as $user)
                        <a wire:key='badge-role-{{$user->id}}'
                            wire:click='confirmHapusUserRole("{{$user->id}}","{{$role->name}}")'
                            class="badge bg-primary text-white font-size-11">{{
                            $user->name }} <i class="bx bx-x my-auto"></i></a>
                        @empty
                        <span class="badge bg-danger text-white font-size-11">No users found.</span>
                        @endforelse
                    </td>
                    <td>
                        @forelse($role->permissions as $permission)
                        <a wire:key='badge-permission-{{$permission->id}}'
                            wire:click='confirmHapusPermission("{{$permission->id}}","{{$role->name}}")'
                            class="badge bg-primary text-white font-size-11">{{ $permission->name }}</a>
                        @empty
                        <span class="badge bg-danger text-white font-size-11">No permissions found.</span>
                        @endforelse
                    </td>
                    <td>
                        <div class="btn-group">
                            <button type="button" wire:key='edit-{{$role->id}}'
                                wire:click='$emit("openUpdateModal", {{$role->id}})' class="btn btn-sm btn-success"><i
                                    class="bx bx-edit"></i></button>
                            <button type="button" wire:key='user-{{$role->id}}'
                                wire:click='$emit("openModalUser", {{$role->id}})' class="btn btn-sm btn-secondary"><i
                                    class="bx bx-user"></i></button>
                            <button type="button" wire:key='permission-{{$role->id}}'
                                wire:click='$emit("openModalPermission", {{$role->id}})'
                                class="btn btn-sm btn-primary"><i class="bx bx-lock"></i></button>
                            <button type="button" wire:key='delete-{{$role->id}}'
                                wire:click='openDialog("{{$role->id}}}}")' class="btn btn-sm btn-danger"><i
                                    class="bx bx-trash"></i></button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="text-center" colspan="5">
                        <h6>Data Tidak ada</h6>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex flex-row">
            <div class="mx-auto">
                {{ $roles->links() }}
            </div>
        </div>
    </div>
</div>