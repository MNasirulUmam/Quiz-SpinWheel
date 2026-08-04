@extends('layouts.app')
@section('title', 'Edit Complaint Type')
@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Edit Complaint Type</h5>
                <div class="card-body">
                    <form action="{{ route('complaint_types.update', $complaintType->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="mb-3">
                            <label for="name" class="form-label">Complaint Type Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $complaintType->name) }}" placeholder="Enter complaint type name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary me-2">Update</button>
                            <a href="{{ route('complaint_types.index') }}" class="btn btn-outline-secondary">Cancel</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
