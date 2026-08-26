@extends('layouts.public')
@section('title', 'Spin Wheel')

@section('content')
<style>
    .quiz-container {
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }

    /* SPIN WHEEL CSS */
    .wheel-wrapper {
        position: relative;
        width: 450px;
        height: 450px;
        margin-bottom: 2.5rem;
        transition: opacity 0.5s ease;
    }

    .wheel {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        border: 12px solid #fff;
        box-shadow: 0 4px 20px rgba(0,0,0,0.15);
        /* 6 segments using conic-gradient */
        background: conic-gradient(
            #ff5252 0deg 60deg,
            #ffb142 60deg 120deg,
            #33d9b2 120deg 180deg,
            #34ace0 180deg 240deg,
            #706fd3 240deg 300deg,
            #ff793f 300deg 360deg
        );
        transition: transform 3s cubic-bezier(0.17, 0.67, 0.12, 0.99);
    }

    .pointer {
        position: absolute;
        top: -20px;
        left: 50%;
        transform: translateX(-50%);
        width: 0; 
        height: 0; 
        border-left: 25px solid transparent;
        border-right: 25px solid transparent;
        border-top: 40px solid #2c3e50;
        z-index: 10;
    }

    /* FLASHCARD CSS */
    .flashcard {
        display: none;
        width: 100%;
        max-width: 600px;
        perspective: 1000px; /* 3D effect */
        animation: fadeInUp 0.8s ease forwards;
    }

    .flashcard-inner {
        position: relative;
        width: 100%;
        min-height: 300px;
        text-align: center;
        transition: transform 0.6s;
        transform-style: preserve-3d;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    }

    .flashcard.is-flipped .flashcard-inner {
        transform: rotateY(180deg);
    }

    .flashcard-front, .flashcard-back {
        position: absolute;
        width: 100%;
        height: 100%;
        -webkit-backface-visibility: hidden; /* Safari */
        backface-visibility: hidden;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        padding: 2rem;
        border-radius: 15px;
        background-color: #fff;
    }

    .flashcard-front {
        border-top: 5px solid #ff8505;
    }

    .flashcard-back {
        background-color: #f8f9fa;
        color: #333;
        transform: rotateY(180deg);
        border-top: 5px solid #28a745;
    }

    .question-text {
        font-size: 1.5rem;
        font-weight: 600;
        color: #333;
        margin-bottom: 1.5rem;
    }

    .answer-text {
        font-size: 1.5rem;
        font-weight: 600;
        color: #28a745;
        margin-bottom: 1.5rem;
    }

    .badge-category {
        position: absolute;
        top: 15px;
        left: 15px;
        font-size: 0.8rem;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>

<div class="quiz-container">
    
    <!-- Bagian Roda Berputar -->
    <div id="wheelSection" class="text-center w-100">
        <h3 class="mb-4 text-primary" style="color: #ff8505 !important;">Semoga Beruntung!</h3>
        <p class="text-muted">Klik tombol Spin untuk mengacak soal Anda.</p>
        
        <div class="wheel-wrapper mx-auto">
            <div class="pointer"></div>
            <div class="wheel" id="spinWheel"></div>
        </div>

        <button id="spinBtn" class="btn btn-lg btn-primary fw-bold px-5 py-3 rounded-pill shadow" style="background-color: #ff8505; border-color: #ff8505; font-size: 1.2rem;">
            <i class='bx bx-sync bx-spin me-2'></i> SPIN SEKARANG!
        </button>
    </div>

    <!-- Bagian Kartu Flashcard -->
    <div id="flashcardSection" class="flashcard">
        <div class="flashcard-inner">
            <!-- Sisi Depan (Pertanyaan) -->
            <div class="flashcard-front">
                @if($question->category)
                    <span class="badge bg-label-primary badge-category">{{ $question->category }}</span>
                @endif
                <h4 class="text-muted mb-2">Pertanyaan:</h4>
                
                @if($question->image_path)
                    <div class="mb-3">
                        <img src="{{ asset($question->image_path) }}" alt="Tebak Gambar" class="img-fluid rounded" style="max-height: 200px; object-fit: contain;">
                    </div>
                @endif

                <div class="question-text">{{ $question->question_text }}</div>
                
                <div id="timerDisplay" class="text-danger fw-bold mb-3" style="font-size: 1.1rem; display: none;">
                    <i class='bx bx-stopwatch'></i> Waktu tersisa: <span id="timeRemaining">30</span> detik
                </div>

                <button id="showAnswerBtn" class="btn btn-primary mt-2">
                    <i class='bx bx-show me-1'></i> Lihat Jawaban
                </button>
            </div>

            <!-- Sisi Belakang (Jawaban) -->
            <div class="flashcard-back">
                <h4 class="text-success mb-2">Jawaban:</h4>
                <div class="answer-text">{{ $question->answer_text }}</div>
                
                <form action="{{ route('quiz.finish') }}" method="POST" class="mt-4">
                    @csrf
                    <input type="hidden" name="question_id" value="{{ $question->id }}">
                    <button type="submit" class="btn btn-success btn-lg shadow">
                        <i class='bx bx-check-circle me-1'></i> Selesai & Simpan
                    </button>
                </form>
            </div>
        </div>
    </div>
    <!-- Audio Elements -->
    <audio id="spinSound" src="{{ asset('assets/voice/mixkit-repeating-arcade-beep-1084.wav') }}" preload="auto"></audio>
    <audio id="successSound" src="{{ asset('assets/voice/mixkit-success-software-tone-2865.wav') }}" preload="auto"></audio>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const spinBtn = document.getElementById('spinBtn');
        const wheel = document.getElementById('spinWheel');
        const wheelSection = document.getElementById('wheelSection');
        const flashcardSection = document.getElementById('flashcardSection');
        const showAnswerBtn = document.getElementById('showAnswerBtn');
        const timerDisplay = document.getElementById('timerDisplay');
        const timeRemainingSpan = document.getElementById('timeRemaining');
        
        // Audio Elements
        const spinSound = document.getElementById('spinSound');
        const successSound = document.getElementById('successSound');

        let isSpinning = false;
        let countdownInterval;
        let timeLeft = 30;

        // SPIN FUNCTION
        spinBtn.addEventListener('click', () => {
            if (isSpinning) return;
            isSpinning = true;
            
            // Play spin sound
            spinSound.currentTime = 0;
            spinSound.play().catch(e => console.log('Audio play failed', e));
            
            // Random degree for rotation (between 5 to 10 full circles + random offset)
            const randomDegree = Math.floor(Math.random() * 360) + (360 * 5); 
            
            // Apply rotation to wheel
            wheel.style.transform = `rotate(${randomDegree}deg)`;
            spinBtn.disabled = true;
            spinBtn.innerHTML = "Memutar...";

            // Wait for animation to finish (3s)
            setTimeout(() => {
                // Stop spin sound
                spinSound.pause();
                spinSound.currentTime = 0;

                // Fade out wheel section
                wheelSection.style.opacity = '0';
                
                setTimeout(() => {
                    // Hide wheel, show flashcard
                    wheelSection.style.display = 'none';
                    flashcardSection.style.display = 'block';
                    
                    // Start 30 seconds countdown
                    timerDisplay.style.display = 'block';
                    countdownInterval = setInterval(() => {
                        timeLeft--;
                        timeRemainingSpan.textContent = timeLeft;
                        
                        if (timeLeft <= 0) {
                            clearInterval(countdownInterval);
                            // Redirect to home if time is up
                            window.location.href = "{{ route('quiz.index') }}";
                        }
                    }, 1000);

                }, 500); // Wait for fade out
                
            }, 3000); 
        });

        // FLIP FLASHCARD FUNCTION
        showAnswerBtn.addEventListener('click', () => {
            // Play success sound
            successSound.currentTime = 0;
            successSound.play().catch(e => console.log('Audio play failed', e));

            // Stop the timer when answer is shown
            clearInterval(countdownInterval);
            timerDisplay.style.display = 'none';

            flashcardSection.classList.add('is-flipped');
        });
    });
</script>
@endsection
