@extends('layouts.public')
@section('title', 'Submit a Complaint')

@section('content')
<div class="row justify-content-center">
    <div class="col-md-8 col-lg-6">
        <div class="card mb-4 mt-3 shadow-sm border-0">
            <div class="card-header pt-4 pb-3 text-center border-bottom" style="background-color: #ff8505;">
                <h4 class="mb-1 text-white fw-bold">Formulir Pengaduan Komplain</h4>
                <p class="mb-0" style="color: #023401; font-weight: 500;">Tulis rincian masalah Anda dengan benar !</p>
            </div>
            <div class="card-body mt-3">

                
                @if (count($errors) > 0)
                  <div class="alert alert-danger">
                    <strong>Failed!</strong> There was a problem with your input.<br><br>
                    <ul>
                       @foreach ($errors->all() as $error)
                         <li>{{ $error }}</li>
                       @endforeach
                    </ul>
                  </div>
                @endif

                <form id="complaintForm" action="{{ route('public.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="mb-3">
                        <label class="form-label text-uppercase">Nama Lengkap <span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-user"></i></span>
                            <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Isi Nama Lengkap" required/>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-uppercase">Nomor Telepon / WhatsApp <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-phone"></i></span>
                                <input type="number" class="form-control" name="number_phone" value="{{ old('number_phone') }}" placeholder="Contoh: 081xxxxxx" required/>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-uppercase">Tanggal Pelayanan <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-calendar"></i></span>
                                <input type="date" class="form-control" name="date" value="{{ old('date', date('Y-m-d')) }}" required/>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-uppercase">Alamat <span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text align-items-start pt-2"><i class="bx bx-map"></i></span>
                            <textarea class="form-control" name="address" rows="2" placeholder="Isi Alamat lengkap" required>{{ old('address') }}</textarea>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-uppercase">Ruangan Pelayanan <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-building-house"></i></span>
                                <select name="division_id" class="form-select" required>
                                    <option value="">-- Pilih Ruangan Pelayanan --</option>
                                    @foreach($divisions as $division)
                                        <option value="{{ $division->id }}" {{ old('division_id') == $division->id ? 'selected' : '' }}>{{ $division->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-uppercase">Jenis Komplain <span class="text-danger">*</span></label>
                            <div class="input-group input-group-merge">
                                <span class="input-group-text"><i class="bx bx-category"></i></span>
                                <select name="complaint_type_id" class="form-select" required>
                                    <option value="">-- Pilih Jenis Komplain --</option>
                                    @foreach($complaintTypes as $type)
                                        <option value="{{ $type->id }}" {{ old('complaint_type_id') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-uppercase">Deskripsi Komplain <span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text align-items-start pt-2"><i class="bx bx-comment-detail"></i></span>
                            <textarea class="form-control" name="description" rows="4" placeholder="Jelaskan keluhan Anda" required>{{ old('description') }}</textarea>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label text-uppercase">Lampiran <span class="text-danger">*</span></label>
                        <div class="input-group input-group-merge">
                            <span class="input-group-text"><i class="bx bx-file"></i></span>
                            <input type="file" class="form-control" name="attachment" accept=".jpg,.jpeg,.png,.pdf,.doc,.docx" required />
                        </div>
                        <small class="text-muted mt-1 d-block">Ukuran file maksimal 5MB (JPG, PNG, PDF, DOCX)</small>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg" style="background-color: #ff8505; border-color: #ff8505;">
                            <i class="icon-base bx bx-paper-plane icon-sm ms-md-4 ms-0"></i> Kirim Pengaduan 
                        </button>
                    </div>

                    <hr class="mt-4 mb-3">
                    <div class="text-center">
                        <small class="text-muted">Terima kasih atas masukan Anda. Saran ini sangat berharga bagi kami untuk terus melakukan perbaikan</small>
                    </div>
                </form>
            </div>
        </div>
        
        <div class="text-center text-muted mb-5">
            <small>&copy; {{ date('Y') }} BHC Report. All Rights Reserved.</small>
        </div>
    </div>
</div>

@if (session('success'))
    <div class="modal fade" id="successModal" tabindex="-1" aria-labelledby="successModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5">
                    <i class="bx bx-check-circle text-success mb-3" style="font-size: 5rem;"></i>
                    <h4 class="modal-title mb-2" id="successModalLabel" style="color: #ff8505;">Berhasil!</h4>
                    <p class="fs-5 mb-1">{{ session('success') }}</p>
                    <p class="text-muted small">Harap simpan kode tiket ini jika Anda ingin melakukan pengecekan status.</p>
                    <button type="button" class="btn btn-primary mt-3" data-bs-dismiss="modal" style="background-color: #ff8505; border-color: #ff8505;">OK, Mengerti</button>
                </div>
            </div>
        </div>
    </div>
@endif

@if (session('status_result'))
    @php
        $result = session('status_result');
    @endphp
    <div class="modal fade" id="statusResultModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" style="color: #ff8505;">Detail Status Komplain</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Kode Tiket</div>
                        <div class="col-sm-8 fw-bold">{{ $result->complaint_code }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Tanggal Lapor</div>
                        <div class="col-sm-8">{{ \Carbon\Carbon::parse($result->created_at)->format('d M Y H:i') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Status Saat Ini</div>
                        <div class="col-sm-8">
                            @if($result->status == 'pending')
                                <span class="badge bg-warning">Pending</span>
                            @elseif($result->status == 'process')
                                <span class="badge bg-info">Diproses</span>
                            @elseif($result->status == 'resolved')
                                <span class="badge bg-success">Selesai (Resolved)</span>
                            @elseif($result->status == 'rejected')
                                <span class="badge bg-danger">Ditolak</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Terakhir Diperbarui</div>
                        <div class="col-sm-8">{{ \Carbon\Carbon::parse($result->updated_at)->format('d M Y H:i') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-sm-4 text-muted">Keluhan</div>
                        <div class="col-sm-8">{{ $result->description }}</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4 text-muted">Tanggapan / Catatan Admin</div>
                        <div class="col-sm-8">
                            @if($result->notes)
                                <div class="p-3 bg-light rounded border">
                                    {{ $result->notes }}
                                </div>
                            @else
                                <em class="text-muted">Belum ada tanggapan.</em>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal" style="background-color: #ff8505; border-color: #ff8505;">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endif

@if (session('status_error'))
    <div class="modal fade" id="statusErrorModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content text-center">
                <div class="modal-header border-0 pb-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body pb-5">
                    <i class="bx bx-error-circle text-danger mb-3" style="font-size: 5rem;"></i>
                    <h4 class="modal-title mb-2 text-danger">Oops!</h4>
                    <p class="fs-5 mb-1">{{ session('status_error') }}</p>
                    <button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal">Tutup</button>
                </div>
            </div>
        </div>
    </div>
@endif

<script>
    // Prevent accidental form submission when pressing Enter
    document.addEventListener('DOMContentLoaded', function () {
        document.getElementById('complaintForm').addEventListener('keypress', function(event) {
            // Check if Enter is pressed and the target is not a textarea
            if (event.keyCode === 13 && event.target.tagName !== 'TEXTAREA') {
                event.preventDefault();
            }
        });

        // Trigger success modal if exists
        @if (session('success'))
            var successModal = new bootstrap.Modal(document.getElementById('successModal'));
            successModal.show();
        @endif

        // Trigger status result modal if exists
        @if (session('status_result'))
            var statusResultModal = new bootstrap.Modal(document.getElementById('statusResultModal'));
            statusResultModal.show();
        @endif

        // Trigger status error modal if exists
        @if (session('status_error'))
            var statusErrorModal = new bootstrap.Modal(document.getElementById('statusErrorModal'));
            statusErrorModal.show();
        @endif
    });
</script>
@endsection
