<div>
    <div class="d-flex flex-row-reverse" style="gap: 10px">
        <button type="button" wire:click='$emit("tambah")' class="btn btn-sm btn-primary"><i
                class="bx bx-plus"></i></button>
        <div class="col-md-3">
            <input type="text" placeholder="Cari....." wire:model='search' class="form-control">
        </div>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Permission</th>
                    <th>Roles</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($permissions as $permission)
                <tr>
                    <td>{{ $permission->id }}</td>
                    <td>{{ $permission->name }}</td>
                    <td>
                        @forelse($permission->roles as $role)
                        <span class="badge badge-primary">{{ $role->name }}</span>
                        @empty
                        <span class="badge badge-danger">No roles found.</span>
                        @endforelse
                    </td>
                    <td>
                        <div class="btn-group">
                            <button type="button" wire:key='delete-{{$permission->id}}'
                                wire:click='$emit("openUpdateModal", {{$permission->id}})'
                                class="btn btn-sm btn-success"><i class="bx bx-edit"></i></button>
                            <button type="button" wire:key='edit-{{$permission->id}}'
                                wire:click='openDialog("{{$permission->id}}}}")' class="btn btn-sm btn-danger"><i
                                    class="bx bx-trash"></i></button>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td class="text-center" colspan="4">
                        <h6>Data Tidak ada</h6>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
        <div class="d-flex flex-row">
            <div class="mx-auto">
                {{ $permissions->links() }}
            </div>
        </div>
    </div>
</div>