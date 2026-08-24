<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PlayerController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:players-list|players-delete', ['only' => ['index','show']]);
         $this->middleware('permission:players-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $players = \App\Models\Player::orderBy('id', 'DESC')->get();
        return view('master.players.index', compact('players'));
    }

    public function destroy(\App\Models\Player $player)
    {
        $player->delete();
        return redirect()->route('players.index')->with('success','Player deleted successfully');
    }
}
