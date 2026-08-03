@extends('layouts.app')
@section('title','Role Management')
@section('content')
<!-- Basic Bootstrap Table -->
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="card">

            <h5 class="card-header">Role List</h5>
            @can('role-create')
            <div class="d-flex justify-content-start mb-3" >
                <a href="{{ route('roles.create') }}" class="btn btn-md btn-info">Create Role</a>
            </div>
            @endcan
            <div class="card-datatable table-responsive">
                <table class="dt-responsive table border-top" id="roleTable" style ="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Level</th>
                            <th>Hak Akses</th>
                            <th>Aksi</th>
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
                                    @foreach($role->permissions as $permission)
                                        <span class="badge bg-label-primary me-1 mb-1">
                                            {{ $permission->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td>
                                    @can('role-edit')
                                    <a href="{{ route('roles.edit',$role->id) }}"
                                    class="btn btn-warning btn-sm">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    @endcan
                                    @can('role-delete')
                                    <form action="{{ route('roles.destroy',$role->id) }}"
                                        method="POST"
                                        style="display:inline-block"
                                        class="form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete">
                                            <i class="bx bx-trash"></i>
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