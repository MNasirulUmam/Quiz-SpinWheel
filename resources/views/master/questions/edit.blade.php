@extends('layouts.app')
@section('title', 'Edit Question')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Master Data / Questions /</span> Edit</h4>

    @if (count($errors) > 0)
        <div class="alert alert-danger">
            <strong>Whoops!</strong> There were some problems with your input.<br><br>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Edit Question</h5>
            <a class="btn btn-secondary" href="{{ route('questions.index') }}"> Back</a>
        </div>
        <div class="card-body">
            <form action="{{ route('questions.update', $question->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="mb-3">
                    <label class="form-label" for="category">Category (Optional)</label>
                    <input type="text" name="category" class="form-control" id="category" value="{{ $question->category }}">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="question_text">Question Text</label>
                    <textarea name="question_text" class="form-control" id="question_text" rows="3" required>{{ $question->question_text }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="image">Image (Optional - Untuk Tebak Gambar)</label>
                    @if($question->image_path)
                        <div class="mb-2">
                            <img src="{{ asset($question->image_path) }}" alt="Question Image" width="150" class="rounded">
                        </div>
                    @endif
                    <input type="file" name="image" class="form-control" id="image" accept="image/*">
                </div>
                <div class="mb-3">
                    <label class="form-label" for="answer_text">Answer Text</label>
                    <textarea name="answer_text" class="form-control" id="answer_text" rows="3" required>{{ $question->answer_text }}</textarea>
                </div>
                <div class="mb-3">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="hidden" name="is_used" value="0">
                        <input class="form-check-input" type="checkbox" id="is_used" name="is_used" value="1" {{ $question->is_used ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_used">Already Used?</label>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Update</button>
            </form>
        </div>
    </div>
</div>
@endsection
