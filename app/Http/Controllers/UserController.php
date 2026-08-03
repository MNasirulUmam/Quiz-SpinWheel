<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('settings.users.index', compact('users'));
    }

    public function create()
    {
        $roles = Role::pluck('name', 'name')->all();
        return view('settings.users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|unique:users,username',
            'nama' => 'required',
            'level' => 'required',
            'password' => 'required|same:confirm-password',
        ]);

        $user = User::create([
            'username' => $request->username,
            'name' => $request->nama,
            'keterangan' => $request->keterangan,
            'password' => Hash::make($request->password),
        ]);

        $user->assignRole($request->level);

        return redirect()->route('users.index')
                        ->with('success', 'User berhasil dibuat');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(User $user)
    {
        $roles = Role::pluck('name', 'name')->all();
        $userRole = $user->roles->pluck('name', 'name')->all();
        
        return view('settings.users.edit', compact('user', 'roles', 'userRole'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'username' => 'required|unique:users,username,'.$user->id,
            'nama' => 'required',
            'level' => 'required',
            'password' => 'nullable|same:confirm-password',
        ]);

        $input = [
            'username' => $request->username,
            'name' => $request->nama,
            'keterangan' => $request->keterangan,
        ];
        
        if(!empty($request->password)){
            $input['password'] = Hash::make($request->password);
        }

        $user->update($input);
        
        // Update role
        $user->syncRoles([$request->level]);

        return redirect()->route('users.index')
                        ->with('success', 'User berhasil diperbarui');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('users.index')
                        ->with('success', 'User berhasil dihapus');
    }
}
