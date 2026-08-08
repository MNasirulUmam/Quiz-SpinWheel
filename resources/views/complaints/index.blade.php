@extends('layouts.app')
@section('title', 'Complaint Management')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="mb-0">Complaint List</h5>
                @can('complaint-create')
                <a href="{{ route('complaints.create') }}" class="btn create-new btn-primary">Create Complaint</a>
                @endcan
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                <table class="table" id="complaintTable" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>Code</th>
                            <th>Date</th>
                            <th>Name</th>
                            <th>Phone</th>
                            <th>Division</th>
                            <th>Complaint Type</th>
                            <th>Status</th>
                            <th style="width: 15%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($complaints as $key => $complaint)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $complaint->complaint_code }}</td>
                                <td>{{ \Carbon\Carbon::parse($complaint->date)->format('d-m-Y') }}</td>
                                <td>{{ $complaint->name }}</td>
                                <td>{{ $complaint->number_phone }}</td>
                                <td>{{ $complaint->division->name ?? '-' }}</td>
                                <td>{{ $complaint->complaintType->name ?? '-' }}</td>
                                <td>
                                    @if($complaint->status == 'pending')
                                        <span class="badge bg-label-warning">Pending</span>
                                    @elseif($complaint->status == 'process')
                                        <span class="badge bg-label-info">Process</span>
                                    @elseif($complaint->status == 'resolved')
                                        <span class="badge bg-label-success">Resolved</span>
                                    @elseif($complaint->status == 'rejected')
                                        <span class="badge bg-label-danger">Rejected</span>
                                    @endif
                                </td>
                                <td>
                                    @can('complaint-show')
                                    <a href="{{ route('complaints.show', $complaint->id) }}" class="btn btn-icon item-show">
                                        <i class="icon-base bx bx-show icon-sm"></i>
                                    </a>
                                    @endcan
                                    @can('complaint-edit')
                                    <a href="{{ route('complaints.edit', $complaint->id) }}" class="btn btn-icon item-edit">
                                        <i class="icon-base bx bx-edit icon-sm"></i>
                                    </a>
                                    @endcan
                                    @can('complaint-delete')
                                    <form action="{{ route('complaints.destroy', $complaint->id) }}" method="POST" style="display:inline-block" class="form-delete">
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
@endsection

@section('script')
<script>
$(document).ready(function(){
    $(document).on('click', '.btn-delete', function(e) {
        e.preventDefault();
        let form = $(this).closest('form');
        Swal.fire({
            title: 'Are you sure?',
            text: "This complaint will be deleted permanently!",
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
        $('#complaintTable').DataTable({
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
