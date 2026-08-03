@extends('layouts.app')
@section('title','Data User')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="card">
            <h5 class="card-header">User Management</h5>
            <div class="d-flex justify-content-start mb-3" >
                <a href="{{ route('users.create') }}" class="btn btn-md btn-info">Create User</a>
            </div>
            <div class="card-datatable table-responsive">
                <table class="dt-responsive table border-top" id="userTable" style ="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Username</th>
                            <th>Fullname</th>
                            <th>Level</th>
                            <th>Description</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $key => $user)
                        <tr>
                            <td>{{ $key+1 }}</td>
                            <td>{{ $user->username }}</td>
                            <td>{{ $user->name }}</td>
                            <td>
                                @if(!empty($user->getRoleNames()))
                                    @foreach($user->getRoleNames() as $v)
                                        <span class="badge bg-label-primary me-1">{{ $v }}</span>
                                    @endforeach
                                @endif
                            </td>
                            <td>{{ $user->keterangan }}</td>
                            <td>
                                <a href="{{ route('users.edit',$user->id) }}" class="btn btn-warning btn-sm">
                                    <i class="bx bx-edit"></i>
                                </a>
                                <form action="{{ route('users.destroy',$user->id) }}" method="POST" style="display:inline-block" class="form-delete">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete">
                                        <i class="bx bx-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')
<script>
$(document).ready(function(){
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        let form = $(this).closest('form');
        Swal.fire({
            title: 'Are you sure?',
            text: "Data user ini akan dihapus permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'Yes, Delete!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                form[0].submit();
            }
        });
    });

    try {
        $('#userTable').DataTable({
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