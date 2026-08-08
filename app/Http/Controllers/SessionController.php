<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SessionController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:session-list|session-delete', ['only' => ['index']]);
         $this->middleware('permission:session-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $sessions = DB::table('sessions')
            ->leftJoin('users', 'sessions.user_id', '=', 'users.id')
            ->select('sessions.*', 'users.name as user_name')
            ->get();
        return view('settings.sessions.index', compact('sessions'));
    }

    public function destroy(string $id)
    {
        DB::table('sessions')->where('id', $id)->delete();
        return redirect()->route('sessions.index')->with('success', 'Session deleted successfully.');
    }
}
