<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GameSessionController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:game_session-list|game_session-delete', ['only' => ['index','show']]);
         $this->middleware('permission:game_session-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $sessions = \App\Models\GameSession::with(['player', 'question'])->orderBy('id', 'DESC')->get();
        return view('master.game_sessions.index', compact('sessions'));
    }

    public function destroy(\App\Models\GameSession $gameSession)
    {
        $gameSession->delete();
        return redirect()->route('game_sessions.index')->with('success','Session record deleted successfully');
    }
}
