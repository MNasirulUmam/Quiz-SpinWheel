@extends('layouts.app')
@section('title','Create User')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Create User</h5>
                <div class="card-body">
                @if (count($errors) > 0)
                  <div class="alert alert-danger">
                    <strong>Failed!</strong> There was a problem with your input.<br><br>
                    <ul>
                       @foreach ($errors->all() as $error)
                         <li>{{ $error }}</li>
                       @endforeach
                    </ul>
                  </div>
                @endif
                <form action="{{ route('users.store') }}" method="POST" id="form-user">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ old('username') }}" required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fullname</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama') }}" required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Level</label>
                        <select name="level" id="level" class="form-control" required>
                            <option value="">-- Select Level --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}">{{ ucfirst($role) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" class="form-control" id="password" name="password" required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm-password" name="confirm-password" required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ old('keterangan') }}"/>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('users.index') }}" class="btn btn-outline-secondary">Back</a>
                        <button type="submit" class="btn btn-primary me-2" id="simpan">Save</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection