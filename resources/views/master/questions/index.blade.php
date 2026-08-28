@extends('layouts.app')
@section('title', 'Questions')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Master Data /</span> Questions</h4>

    @php
        $totalQuestions = count($questions);
        $unusedQuestions = $questions->where('is_used', 0)->count();
    @endphp

    @if($totalQuestions > 0 && $unusedQuestions == 0)
    <div class="alert alert-warning alert-dismissible" role="alert">
        <i class="bx bx-error-circle me-1"></i> Semua soal sudah habis digunakan. Silahkan tambah data soal atau edit soal agar bisa digunakan lagi.
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">List of Questions</h5>
            <div>
                @can('question-create')
                <button type="button" class="btn btn-success me-2" data-bs-toggle="modal" data-bs-target="#importExcelModal">
                    <i class="bx bx-import me-1"></i> Import Excel
                </button>
                <a class="btn btn-primary" href="{{ route('questions.create') }}"> Create New Question</a>
                @endcan
            </div>
        </div>
        <div class="card-body">

<!-- Modal Import Excel -->
<div class="modal fade" id="importExcelModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered" role="document">
    <div class="modal-content">
      <form action="{{ route('questions.import') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal-header">
          <h5 class="modal-title" id="modalCenterTitle">Import Data Soal (Excel)</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div class="row">
            <div class="col mb-3">
              <label for="file" class="form-label">Pilih File Excel (.xlsx, .csv)</label>
              <input type="file" id="file" name="file" class="form-control" accept=".xlsx, .xls, .csv" required>
            </div>
          </div>
          <div class="row mt-2">
            <div class="col">
              <div class="alert alert-info">
                <strong>Format Kolom yang dibutuhkan (Tanpa Header):</strong><br>
                Kolom 1: Kategori (Opsional)<br>
                Kolom 2: Pertanyaan (Wajib)<br>
                Kolom 3: Jawaban (Wajib)<br>
                <a href="{{ route('questions.template') }}" class="alert-link mt-2 d-inline-block"><i class="bx bx-download me-1"></i> Download Template</a>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Batal</button>
          <button type="submit" class="btn btn-success">Import Data</button>
        </div>
      </form>
    </div>
  </div>
</div>
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Category</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Used?</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($questions as $key => $question)
                        <tr>
                            <td>{{ $key + 1 }}</td>
                            <td>{{ $question->category ?? '-' }}</td>
                            <td style="white-space: normal; min-width: 200px;">
                                {{ $question->question_text }}
                                @if($question->image_path)
                                    <br><span class="badge bg-label-info mt-1"><i class='bx bx-image'></i> Gambar</span>
                                @endif
                            </td>
                            <td style="white-space: normal; min-width: 200px;">{{ $question->answer_text }}</td>
                            <td>
                                @if($question->is_used)
                                    <span class="badge bg-label-success">Yes</span>
                                @else
                                    <span class="badge bg-label-secondary">No</span>
                                @endif
                            </td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow" data-bs-toggle="dropdown"><i class="bx bx-dots-vertical-rounded"></i></button>
                                    <div class="dropdown-menu">
                                        @can('question-edit')
                                        <a class="dropdown-item" href="{{ route('questions.edit',$question->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
                                        @endcan
                                        @can('question-delete')
                                        <form action="{{ route('questions.destroy', $question->id) }}" method="POST" style="display:inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="dropdown-item" onclick="return confirm('Are you sure?')"><i class="bx bx-trash me-1"></i> Delete</button>
                                        </form>
                                        @endcan
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    $(document).ready(function() {
        $('.table').DataTable({
            "pageLength": 10
        });
    });
</script>
@endpush
@endsection
