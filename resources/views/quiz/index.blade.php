@extends('layouts.public')
@section('title', 'Mulai Kuis')

@section('content')
<div class="row justify-content-center align-items-center" style="min-height: 100vh;">
    <div class="col-lg-6 col-12 mb-6">
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="card shadow-sm border-0">
            <div class="card-body p-8 text-center">
                <img src="{{ asset('assets/img/logo/logo.png') }}" alt="Logo" class="mb-3" style="max-height: 150px;">
                
                <form action="{{ route('quiz.register') }}" method="POST">
                    @csrf
                    <div class="mb-3 text-start">
                        <label for="name" class="form-label fw-bold">Nama Lengkap <span class="text-danger">*</span></label>
                        <input type="text" class="form-control form-control-lg" id="name" name="name" required placeholder="Contoh: Budi Santoso">
                    </div>
                    <div class="mb-4 text-start">
                        <label for="institution" class="form-label fw-bold">Asal</label>
                        <input type="text" class="form-control form-control-lg" id="institution" name="institution" placeholder="Contoh: SMA 1 / Kelas 12 (Opsional)">
                    </div>
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-lg btn-primary fw-bold" style="background-color: #ff8505; border-color: #ff8505;">Mulai Bermain</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Cari semua elemen alert (baik success maupun error)
        const alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            // Set timer 5 detik (5000 ms)
            setTimeout(() => {
                alert.style.transition = "opacity 0.5s ease";
                alert.style.opacity = "0";
                
                // Hapus elemen sepenuhnya setelah animasi memudar selesai (500 ms)
                setTimeout(() => alert.remove(), 500); 
            }, 5000);
        });
    });
</script>
@endsection
