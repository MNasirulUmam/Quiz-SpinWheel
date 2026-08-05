@extends('layouts.app')
@section('title', 'Division Management')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="mb-0">Division List</h5>
                <a href="{{ route('divisions.create') }}" class="btn create-new btn-primary">Create Division</a>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                <table class="table" id="divisionTable" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>Division Name</th>
                            <th style="width: 15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($divisions as $key => $division)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $division->name }}</td>
                                <td>
                                    <a href="{{ route('divisions.edit', $division->id) }}" class="btn btn-icon item-edit">
                                        <i class="icon-base bx bx-edit icon-sm"></i>
                                    </a>
                                    <form action="{{ route('divisions.destroy', $division->id) }}" method="POST" style="display:inline-block" class="form-delete">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-icon btn-delete">
                                            <i class="icon-base bx bx-trash icon-sm"></i>
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
            text: "This division will be deleted permanently!",
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
        $('#divisionTable').DataTable({
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
