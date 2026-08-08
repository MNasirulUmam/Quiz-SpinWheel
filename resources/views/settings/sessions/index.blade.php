@extends('layouts.app')
@section('title', 'Sessions Management')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="d-flex justify-content-between align-items-center p-3">
                <h5 class="mb-0">Active Sessions</h5>
            </div>
            <div class="card-body">
                <div class="table-responsive text-nowrap">
                <table class="table" id="sessionsTable" style="width:100%">
                    <thead>
                        <tr>
                            <th style="width: 5%">No</th>
                            <th>User</th>
                            <th>IP Address</th>
                            <th>User Agent</th>
                            <th>Last Activity</th>
                            <th style="width: 10%">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($sessions as $key => $session)
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>
                                    @if($session->user_name)
                                        <span class="badge bg-primary">{{ $session->user_name }}</span>
                                    @else
                                        <span class="badge bg-secondary">Guest</span>
                                    @endif
                                </td>
                                <td>{{ $session->ip_address }}</td>
                                <td>
                                    <span class="d-inline-block text-truncate" style="max-width: 250px;" title="{{ $session->user_agent }}">
                                        {{ $session->user_agent }}
                                    </span>
                                </td>
                                <td>{{ \Carbon\Carbon::createFromTimestamp($session->last_activity)->format('d-m-Y H:i:s') }}</td>
                                <td>
                                    @can('session-delete')
                                    <form action="{{ route('sessions.destroy', $session->id) }}" method="POST" style="display:inline-block" class="form-delete">
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
            text: "This session will be deleted and the user will be logged out!",
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
        $('#sessionsTable').DataTable({
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
