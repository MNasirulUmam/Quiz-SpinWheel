@extends('layouts.app')
@section('title', 'Players')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">History /</span> Players</h4>



    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">List of Players</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Institution / Class</th>
                            <th>Played At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($players as $key => $player)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $player->name }}</td>
                            <td>{{ $player->institution ?? '-' }}</td>
                            <td>{{ $player->created_at->format('d M Y H:i') }}</td>
                            <td>
                                @can('players-delete')
                                <form action="{{ route('players.destroy', $player->id) }}" method="POST" style="display:inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')"><i class="bx bx-trash me-1"></i> Delete</button>
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

@push('scripts')
<script>
    $(document).ready(function() {
        $('.table').DataTable({
            "pageLength": 10
        });
    });
</script>
@endpush
@endsection
