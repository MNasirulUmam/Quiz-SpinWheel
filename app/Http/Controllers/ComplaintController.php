<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ComplaintController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:complaint-list|complaint-create|complaint-edit|complaint-delete|complaint-show', ['only' => ['index']]);
         $this->middleware('permission:complaint-show', ['only' => ['show']]);
         $this->middleware('permission:complaint-create', ['only' => ['create','store']]);
         $this->middleware('permission:complaint-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:complaint-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $complaints = Complaint::with(['complaintType', 'division'])->latest()->get();
        return view('complaints.index', compact('complaints'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $complaintTypes = \App\Models\ComplaintType::all();
        $divisions = \App\Models\Division::all();
        return view('complaints.create', compact('complaintTypes', 'divisions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'number_phone' => 'required|numeric',
            'address' => 'required|string',
            'description' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:5120',
            'complaint_type_id' => 'required|exists:complaint_types,id',
            'division_id' => 'required|exists:divisions,id',
            'date' => 'required|date',
        ]);

        $data = $request->except('attachment');
        $data['status'] = 'pending';

        if ($request->hasFile('attachment')) {
            $path = $request->file('attachment')->store('complaints', 'public');
            $data['attachment'] = $path;
        }

        $type = \App\Models\ComplaintType::find($request->complaint_type_id);
        $division = \App\Models\Division::find($request->division_id);
        
        $data['complaint_code'] = ($type->code ?? '') . ($division->code ?? '');

        $complaint = Complaint::create($data);
        $complaint->update(['complaint_code' => $data['complaint_code'] . '-' . $complaint->id]);

        return redirect()->route('complaints.index')
                         ->with('success', 'Complaint created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Complaint $complaint)
    {
        return view('complaints.show', compact('complaint'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Complaint $complaint)
    {
        $complaintTypes = \App\Models\ComplaintType::all();
        $divisions = \App\Models\Division::all();
        return view('complaints.edit', compact('complaint', 'complaintTypes', 'divisions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Complaint $complaint)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'number_phone' => 'required|numeric',
            'address' => 'required|string',
            'description' => 'required|string',
            'attachment' => 'nullable|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:5120',
            'complaint_type_id' => 'required|exists:complaint_types,id',
            'division_id' => 'required|exists:divisions,id',
            'date' => 'required|date',
            'status' => 'required|in:pending,process,resolved,rejected',
            'notes' => 'nullable|string'
        ]);

        $data = $request->except('attachment');

        if ($request->hasFile('attachment')) {
            // Delete old attachment if exists
            if ($complaint->attachment && Storage::disk('public')->exists($complaint->attachment)) {
                Storage::disk('public')->delete($complaint->attachment);
            }
            $path = $request->file('attachment')->store('complaints', 'public');
            $data['attachment'] = $path;
        }

        $type = \App\Models\ComplaintType::find($request->complaint_type_id);
        $division = \App\Models\Division::find($request->division_id);
        
        $data['complaint_code'] = ($type->code ?? '') . ($division->code ?? '') . '-' . $complaint->id;

        $complaint->update($data);

        return redirect()->route('complaints.index')
                         ->with('success', 'Complaint updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Complaint $complaint)
    {
        $complaint->delete();

        return redirect()->route('complaints.index')
                         ->with('success', 'Complaint deleted successfully.');
    }
}
