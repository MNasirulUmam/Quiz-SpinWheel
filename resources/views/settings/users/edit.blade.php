@extends('layouts.app')
@section('title','Edit User')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Edit User</h5>
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
                <form action="{{ route('users.update', $user->id) }}" method="POST" id="form-user">
                    @csrf
                    @method('PATCH')
                    <input type="hidden" name="id" value="{{ $user->id }}" />
                    <div class="mb-3">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="{{ old('username', $user->username) }}" required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Fullname</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $user->name) }}" required/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Level</label>
                        <select name="level" id="level" class="form-control" required>
                            <option value="">-- Select Level --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role }}" {{ in_array($role, $userRole) ? 'selected' : '' }}>{{ ucfirst($role) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password (Leave empty if you don't want to change it)</label>
                        <input type="password" class="form-control" id="password" name="password"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="confirm-password" name="confirm-password"/>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Description</label>
                        <input type="text" class="form-control" id="keterangan" name="keterangan" value="{{ old('keterangan', $user->keterangan) }}"/>
                    </div>
                    <div class="mb-3">
                        <a href="{{ route('users.index') }}" class="btn btn-md btn-secondary">Back</a>
                        <button type="submit" class="btn btn-md btn-success" id="simpan">Save</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
@endsection