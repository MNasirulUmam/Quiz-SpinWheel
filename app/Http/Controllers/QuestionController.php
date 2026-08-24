<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\QuestionsImport;

class QuestionController extends Controller
{
    function __construct()
    {
         $this->middleware('permission:question-list|question-create|question-edit|question-delete', ['only' => ['index','show']]);
         $this->middleware('permission:question-create', ['only' => ['create','store']]);
         $this->middleware('permission:question-edit', ['only' => ['edit','update']]);
         $this->middleware('permission:question-delete', ['only' => ['destroy']]);
    }

    public function index()
    {
        $questions = \App\Models\Question::orderBy('id', 'DESC')->get();
        return view('master.questions.index', compact('questions'));
    }

    public function create()
    {
        return view('master.questions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'question_text' => 'required',
            'answer_text' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/questions'), $imageName);
            $data['image_path'] = 'images/questions/' . $imageName;
        }

        \App\Models\Question::create($data);
        return redirect()->route('questions.index')->with('success','Question created successfully.');
    }

    public function edit(\App\Models\Question $question)
    {
        return view('master.questions.edit', compact('question'));
    }

    public function update(Request $request, \App\Models\Question $question)
    {
        $request->validate([
            'question_text' => 'required',
            'answer_text' => 'required',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('images/questions'), $imageName);
            $data['image_path'] = 'images/questions/' . $imageName;
            
            // Delete old image if exists
            if ($question->image_path && file_exists(public_path($question->image_path))) {
                unlink(public_path($question->image_path));
            }
        }

        $question->update($data);
        return redirect()->route('questions.index')->with('success','Question updated successfully');
    }

    public function destroy(\App\Models\Question $question)
    {
        if ($question->image_path && file_exists(public_path($question->image_path))) {
            unlink(public_path($question->image_path));
        }

        $question->delete();
        return redirect()->route('questions.index')->with('success','Question deleted successfully');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new QuestionsImport, $request->file('file'));
            return redirect()->route('questions.index')->with('success', 'Data soal berhasil di-import!');
        } catch (\Exception $e) {
            return redirect()->route('questions.index')->with('error', 'Terjadi kesalahan saat meng-import: ' . $e->getMessage());
        }
    }

    public function downloadTemplate()
    {
        return Excel::download(new \App\Exports\QuestionsTemplateExport, 'questions-template.xlsx');
    }
}
