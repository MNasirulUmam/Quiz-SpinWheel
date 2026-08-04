<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComplaintTypeController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:complaint_type-list|complaint_type-create|complaint_type-edit|complaint_type-delete', ['only' => ['index','store']]);
         $this->middleware('permission:complaint_type-create', ['only' => ['create','store']]);
         $this->middleware('permission:complaint_type-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:complaint_type-delete', ['only' => ['destroy']]);
    }
    public function index()
    {
        $complaint_types = \App\Models\ComplaintType::latest()->get();
        return view('master.complaint_types.index', compact('complaint_types'));
    }

    public function create()
    {
        return view('master.complaint_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        \App\Models\ComplaintType::create($request->all());

        return redirect()->route('complaint_types.index')->with('success', 'Complaint Type created successfully.');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(\App\Models\ComplaintType $complaintType)
    {
        return view('master.complaint_types.edit', compact('complaintType'));
    }

    public function update(Request $request, \App\Models\ComplaintType $complaintType)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);

        $complaintType->update($request->all());

        return redirect()->route('complaint_types.index')->with('success', 'Complaint Type updated successfully.');
    }

    public function destroy(\App\Models\ComplaintType $complaintType)
    {
        $complaintType->delete();

        return redirect()->route('complaint_types.index')->with('success', 'Complaint Type deleted successfully.');
    }
}
