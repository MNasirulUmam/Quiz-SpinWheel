<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\Question;
use App\Models\GameSession;
use Illuminate\Support\Facades\Session;

class QuizController extends Controller
{
    // 1. Tampilkan Halaman Pendaftaran
    public function index()
    {
        return view('quiz.index');
    }

    // 2. Simpan Data Pemain
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'institution' => 'nullable|string|max:255',
        ]);

        $player = Player::create([
            'name' => $request->name,
            'institution' => $request->institution,
        ]);

        // Simpan player_id di session
        Session::put('player_id', $player->id);

        return redirect()->route('quiz.play');
    }

    // 3. Tampilkan Halaman Permainan (Spin Wheel)
    public function play()
    {
        // Pastikan pemain sudah daftar (ada di session)
        if (!Session::has('player_id')) {
            return redirect()->route('quiz.index')->with('error', 'Silakan isi data diri terlebih dahulu.');
        }

        // Ambil 1 soal acak yang belum dipakai
        $question = Question::where('is_used', false)->inRandomOrder()->first();

        // Jika semua soal sudah terpakai
        if (!$question) {
            return redirect()->route('quiz.index')->with('error', 'Maaf, semua soal sudah habis terjawab.');
        }

        return view('quiz.play', compact('question'));
    }

    // 4. Selesaikan Permainan & Simpan GameSession
    public function finish(Request $request)
    {
        $playerId = Session::get('player_id');
        $questionId = $request->input('question_id');

        if ($playerId && $questionId) {
            // Tandai soal sudah dipakai
            $question = Question::find($questionId);
            if ($question) {
                $question->update(['is_used' => true]);

                // Simpan riwayat permainan
                GameSession::create([
                    'player_id' => $playerId,
                    'question_id' => $questionId,
                    'played_at' => now(),
                ]);
            }
        }

        // Hapus session agar tidak bisa main lagi tanpa daftar
        Session::forget('player_id');

        return redirect()->route('quiz.index')->with('success', 'Permainan selesai! Terima kasih sudah berpartisipasi.');
    }
}
