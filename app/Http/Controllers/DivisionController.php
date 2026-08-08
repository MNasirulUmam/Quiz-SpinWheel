<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DivisionController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:division-list|division-create|division-edit|division-delete', ['only' => ['index','store']]);
         $this->middleware('permission:division-create', ['only' => ['create','store']]);
         $this->middleware('permission:division-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:division-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $divisions = \App\Models\Division::latest()->get();
        return view('master.divisions.index', compact('divisions'));
    }

    public function create()
    {
        return view('master.divisions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|numeric|digits_between:1,3|unique:divisions,code'
        ]);

        \App\Models\Division::create($request->all());

        return redirect()->route('divisions.index')->with('success', 'Division created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(\App\Models\Division $division)
    {
        return view('master.divisions.edit', compact('division'));
    }

    public function update(Request $request, \App\Models\Division $division)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|numeric|digits_between:1,3|unique:divisions,code,' . $division->id
        ]);

        $division->update($request->all());

        return redirect()->route('divisions.index')->with('success', 'Division updated successfully.');
    }

    public function destroy(\App\Models\Division $division)
    {
        $division->delete();

        return redirect()->route('divisions.index')->with('success', 'Division deleted successfully.');
    }
}
