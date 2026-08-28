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
            'name' => ['required', 'string', 'max:255', 'regex:/^[a-zA-Z\s]+$/'],
            'institution' => 'nullable|string|max:255',
        ], [
            'name.regex' => 'Nama hanya boleh berisi huruf dan spasi.',
        ]);

        $player = Player::firstOrCreate([
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

        // Ambil player_id dan langsung hapus dari session (agar F5 lari ke halaman registrasi)
        $playerId = Session::pull('player_id');

        // Ambil 1 soal acak yang belum dipakai
        $question = Question::where('is_used', false)->inRandomOrder()->first();

        // Jika semua soal sudah terpakai
        if (!$question) {
            return redirect()->route('quiz.index')->with('error', 'Maaf, semua soal sudah habis terjawab.');
        }

        // Tandai soal sudah dipakai dan simpan langsung ke riwayat
        $question->update(['is_used' => true]);

        GameSession::create([
            'player_id' => $playerId,
            'question_id' => $question->id,
            'played_at' => now(),
        ]);

        return view('quiz.play', compact('question'));
    }

    // 4. Selesaikan Permainan & Simpan GameSession
    public function finish(Request $request)
    {
        // Karena data GameSession sudah disimpan di awal halaman play,
        // tombol "Selesai & Simpan" hanya bertugas memulangkan user ke halaman awal.
        return redirect()->route('quiz.index')->with('success', 'Permainan selesai! Terima kasih sudah berpartisipasi.');
    }
}
