@extends('layouts.app')
@section('title','Role Management')
@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
            <h5 class="card-header">Edit Level {{ ucfirst($role->name) }}</h5>
            <form action="{{ route('roles.update',$role->id) }}" method="POST" id="form-menu">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="mb-3">
                    <label class="form-label" for="name">Role Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" id="name" name="name" value="{{ $role->name }}" placeholder="Masukkan nama role" required>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table class="dt-responsive table border-top">
                    <thead>
                        <tr>
                            <th>Level</th>
                            <th>
                                <div class="row gy-3">
                                    <div class="col-md-9">
                                        <div class="form-check form-check-inline mt-3">
                                            <label class="form-check-label">Permissions </label> 
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-check form-check-inline mt-3">
                                            <input type="checkbox" name="select-all" class="form-check-input" id="select-all" /><label class="form-check-label">Select All </label> 
                                        </div>
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($groups as $module => $actions)

                        <tr>

                            <td class="align-middle">

                                <strong>{{ ucfirst($module) }}</strong>

                            </td>

                            <td>

                                <div class="row">

                                    @foreach(['list','create','edit','delete'] as $action)

                                    <div class="col-md-3">

                                        @if(isset($actions[$action]))

                                        <div class="form-check mb-2">

                                            <input
                                                class="form-check-input permission"
                                                type="checkbox"
                                                name="permission[]"
                                                value="{{ $actions[$action]->name }}"
                                                {{ in_array($actions[$action]->name,$rolePermissions) ? 'checked' : '' }}>

                                            <label class="form-check-label">

                                                {{ ucfirst($action) }}

                                            </label>

                                        </div>

                                        @endif

                                    </div>

                                    @endforeach

                                </div>

                            </td>

                        </tr>

                        @endforeach

                        </tbody>
                    </tbody>
                </table>
            </div>
            <div class="card-body">
                <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary">Back</a>
                <button type="submit" class="btn btn-primary me-2" id="simpan">Update</button>
            </div>
            </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
<script>
document.getElementById('select-all').addEventListener('change', function () {

    document.querySelectorAll('.permission').forEach(function(item){
        item.checked = event.target.checked;
    });

});
</script>
@endpush