@extends('layouts.app')
@section('title','Role Management')
@section('content')
<!-- Basic Bootstrap Table -->
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="d-flex justify-content-between align-items-center p-3">
                    <h5 class="mb-0">Role List</h5>
                    @can('role-create')
                    <a href="{{ route('roles.create') }}" class="btn create-new btn-primary">Create Role</a>
                    @endcan
                </div>
                
                <div class="card-body">
                    <div class="table-responsive text-nowrap">
                        <table class="table" id="roleTable" style ="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th style="width: 20%">Level</th>
                            <th>Hak Akses</th>
                            <th style="width: 15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                       @foreach($roles as $key => $role)
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>
                                    <strong>{{ ucfirst($role->name) }}</strong>
                                </td>
                                <td>
                                    @php
                                        $grouped = [];
                                        foreach($role->permissions as $perm) {
                                            $parts = explode('-', $perm->name);
                                            $module = ucfirst(str_replace('_', ' ', $parts[0]));
                                            $action = ucfirst($parts[1] ?? 'other');
                                            $grouped[$module][] = $action;
                                        }
                                    @endphp
                                    <ol class="ps-3 mb-0 text-secondary" style="font-size: 0.95rem;">
                                        @foreach($grouped as $module => $actions)
                                            <li>{{ $module }},
                                                @foreach($actions as $action)
                                                    {{ $action }}:1{{ !$loop->last ? ', ' : '' }}
                                                @endforeach
                                            </li>
                                        @endforeach
                                    </ol>
                                </td>
                                <td>
                                    @can('role-edit')
                                    <a href="{{ route('roles.edit',$role->id) }}"
                                    class="btn btn-icon item-edit">
                                        <i class="icon-base bx bx-edit icon-sm"></i>
                                    </a>
                                    @endcan
                                    @can('role-delete')
                                    <form action="{{ route('roles.destroy',$role->id) }}"
                                        method="POST"
                                        style="display:inline-block"
                                        class="form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-icon btn-delete">
                                            <i class="icon-base bx bx-trash icon-sm"></i>
                                        </button>
                                    </form>
                                    @endcan
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
<!--/ Basic Bootstrap Table -->
@endsection
@section('script')

<script>

$(document).ready(function(){

    // Bind event globally to support DataTables pagination
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        let form = $(this).closest('form');
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Data role ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                form[0].submit();
            }
        });
    });

    try {
        $('#roleTable').DataTable({
            responsive:true,
            language:{
                search:"Search :",
                lengthMenu:"Show _MENU_ entries",
                info:"Showing _START_ to _END_ of _TOTAL_ entries",
                paginate:{
                    previous:"Previous",
                    next:"Next"
                },
                zeroRecords:"Data not found"
            }
        });
    } catch(err) {
        console.warn("DataTables library not loaded", err);
    }

});

</script>

@endsection