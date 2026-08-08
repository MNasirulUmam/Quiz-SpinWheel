@extends('layouts.app')
@section('title', 'Show Complaint')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-4">
                <h5 class="card-header">Complaint Details - {{ $complaint->complaint_code }}</h5>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Date</div>
                        <div class="col-md-9">{{ \Carbon\Carbon::parse($complaint->date)->format('d F Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Reporter Name</div>
                        <div class="col-md-9">{{ $complaint->name }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Phone Number</div>
                        <div class="col-md-9">{{ $complaint->number_phone }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Address / Location</div>
                        <div class="col-md-9">{{ $complaint->address }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Division</div>
                        <div class="col-md-9">{{ $complaint->division->name ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Complaint Type</div>
                        <div class="col-md-9">{{ $complaint->complaintType->name ?? '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Description</div>
                        <div class="col-md-9">{!! nl2br(e($complaint->description)) !!}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Status</div>
                        <div class="col-md-9">
                            @if($complaint->status == 'pending')
                                <span class="badge bg-label-warning">Pending</span>
                            @elseif($complaint->status == 'process')
                                <span class="badge bg-label-info">Process</span>
                            @elseif($complaint->status == 'resolved')
                                <span class="badge bg-label-success">Resolved</span>
                            @elseif($complaint->status == 'rejected')
                                <span class="badge bg-label-danger">Rejected</span>
                            @endif
                        </div>
                    </div>
                    
                    @if($complaint->attachment)
                    <div class="row mb-3">
                        <div class="col-md-3 fw-bold">Attachment</div>
                        <div class="col-md-9">
                            @php
                                $ext = pathinfo($complaint->attachment, PATHINFO_EXTENSION);
                                $isImage = in_array(strtolower($ext), ['jpg', 'jpeg', 'png', 'gif', 'svg']);
                            @endphp
                            
                            @if($isImage)
                                <img src="{{ asset('storage/' . $complaint->attachment) }}" alt="Attachment" class="img-fluid rounded" style="max-width: 400px; border: 1px solid #ddd; padding: 5px;">
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $complaint->attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">View Full Image</a>
                                </div>
                            @else
                                <a href="{{ asset('storage/' . $complaint->attachment) }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                    <i class="bx bx-file"></i> View/Download Document
                                </a>
                            @endif
                        </div>
                    </div>
                    @endif

                    <div class="mt-4 border-top pt-3">
                        <a href="{{ route('complaints.index') }}" class="btn btn-secondary">Back to List</a>
                        @can('complaint-edit')
                        <a href="{{ route('complaints.edit', $complaint->id) }}" class="btn btn-primary me-2">Edit Complaint</a>
                        @endcan
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
