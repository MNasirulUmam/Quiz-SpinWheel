<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->user();

        $request->validate([
            'username' => 'required|unique:users,username,'.$user->id,
            'name' => 'required',
            'password' => 'nullable|same:confirm-password',
        ]);

        $input = [
            'username' => $request->username,
            'name' => $request->name,
            'keterangan' => $request->keterangan,
        ];
        
        if(!empty($request->password)){
            $input['password'] = Hash::make($request->password);
        }

        $user->update($input);

        return redirect()->back()->with('success', 'Profile updated successfully');
    }
}
