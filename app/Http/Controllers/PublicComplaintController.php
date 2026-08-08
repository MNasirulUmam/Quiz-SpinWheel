<?php

namespace App\Http\Controllers;

use App\Models\Complaint;
use Illuminate\Http\Request;

class PublicComplaintController extends Controller
{
    public function create()
    {
        $complaintTypes = \App\Models\ComplaintType::all();
        $divisions = \App\Models\Division::all();
        return view('public.form', compact('complaintTypes', 'divisions'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'number_phone' => 'required|numeric',
            'address' => 'required|string',
            'description' => 'required|string',
            'attachment' => 'required|file|mimes:jpeg,png,jpg,pdf,doc,docx|max:5120',
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

        return redirect()->route('public.form')
                         ->with('success', 'Your complaint has been submitted successfully! Ticket Code: ' . $complaint->complaint_code);
    }

    public function checkStatus(Request $request)
    {
        $request->validate([
            'complaint_code' => 'required|string'
        ]);

        $complaint = Complaint::where('complaint_code', $request->complaint_code)->first();

        if ($complaint) {
            return redirect()->route('public.form')->with('status_result', $complaint);
        } else {
            return redirect()->route('public.form')->with('status_error', 'Ticket Code tidak ditemukan. Silakan periksa kembali.');
        }
    }
}
