@extends('layouts.app')
@section('title', 'Complaint Type Management')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="card">
            <h5 class="card-header">Complaint Type List</h5>
            
            <div class="d-flex justify-content-start mb-3">
                <a href="{{ route('complaint_types.create') }}" class="btn btn-md btn-info">Create Complaint Type</a>
            </div>
            
            @if(session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card-datatable table-responsive">
                <table class="dt-responsive table border-top" id="complaintTypeTable" style="width:100%">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Complaint Type Name</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($complaint_types as $key => $type)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $type->name }}</td>
                                <td>
                                    <a href="{{ route('complaint_types.edit', $type->id) }}" class="btn btn-warning btn-sm">
                                        <i class="bx bx-edit"></i>
                                    </a>
                                    <form action="{{ route('complaint_types.destroy', $type->id) }}" method="POST" style="display:inline-block" class="form-delete">
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
            text: "This complaint type will be deleted permanently!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#8592a3',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                form[0].submit();
            }
        });
    });

    try {
        $('#complaintTypeTable').DataTable({
            responsive: true,
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                paginate: {
                    previous: "Previous",
                    next: "Next"
                },
                zeroRecords: "Data not found"
            }
        });
    } catch(err) {
        console.warn("DataTables library not loaded", err);
    }
});
</script>
@endsection
