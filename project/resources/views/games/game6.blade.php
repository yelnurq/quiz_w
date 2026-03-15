@extends('layouts.app')

@section('title', 'IT-Логика | Истина или Ложь')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8 flex justify-between items-center">
        <a href="{{ route('dashboard') }}" class="text-gray-600 font-bold hover:text-blue-600 transition">⬅ В меню</a>
        <div class="bg-white px-6 py-2 rounded-2xl shadow-sm border-2 border-blue-400 font-black text-blue-600">
            Верно: <span id="score">0</span>
        </div>
    </div>
    <div id="game-card" class="bg-white rounded-[3rem] p-10 shadow-2xl border-4 border-white text-center relative overflow-hidden">
        <div id="timer-bar" class="absolute top-0 left-0 h-2 bg-blue-500 transition-all linear" style="width: 100%"></div>
        
        <div id="question-area">
            <span class="text-6xl mb-6 block" id="emoji">🤔</span>
            <h2 id="question-text" class="text-2xl md:text-3xl font-bold text-gray-800 mb-10 leading-tight">
                Нажми кнопку, чтобы начать!
            </h2>
            
            <div class="grid grid-cols-2 gap-6">
                <button onclick="checkAnswer(true)" class="bg-green-500 hover:bg-green-600 text-white font-black py-6 rounded-3xl shadow-lg transition-transform active:scale-95 text-xl uppercase">
                    Истина 👍
                </button>
                <button onclick="checkAnswer(false)" class="bg-red-500 hover:bg-red-600 text-white font-black py-6 rounded-3xl shadow-lg transition-transform active:scale-95 text-xl uppercase">
                    Ложь 👎
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    const questions = [
        { text: "Клавиатура — это устройство ввода информации", ans: true, e: "⌨️" },
        { text: "Монитор нужен для печати на бумаге", ans: false, e: "🖥️" },
        { text: "Алгоритм — это четкий порядок действий", ans: true, e: "📋" },
        { text: "Информация в компьютере хранится в виде нулей и единиц", ans: true, e: "💾" },
        { text: "Принтер — это устройство ввода", ans: false, e: "🖨️" },
        { text: "Компьютерный вирус полезен для компьютера", ans: false, e: "🦠" },
        { text: "Процессор — это «мозг» компьютера", ans: true, e: "🧠" },
        { text: "Сканер передает изображение с бумаги в компьютер", ans: true, e: "📠" }
    ];

    let currentQ = 0;
    let score = 0;
    let timer;

    function nextQuestion() {
        if (currentQ >= questions.length) {
            alert("Круто! Ты прошел все вопросы. Твой счет: " + score);
            location.reload();
            return;
        }

        const q = questions[currentQ];
        document.getElementById('question-text').innerText = q.text;
        document.getElementById('emoji').innerText = q.e;
        resetTimer();
    }

    function checkAnswer(userAns) {
        if (userAns === questions[currentQ].ans) {
            score++;
            document.getElementById('score').innerText = score;
            document.getElementById('game-card').classList.add('bg-green-50');
            setTimeout(() => document.getElementById('game-card').classList.remove('bg-green-50'), 300);
        } else {
            document.getElementById('game-card').classList.add('bg-red-50');
            setTimeout(() => document.getElementById('game-card').classList.remove('bg-red-50'), 300);
        }
        currentQ++;
        nextQuestion();
    }

    function resetTimer() {
        clearInterval(timer);
        let width = 100;
        timer = setInterval(() => {
            width -= 1;
            document.getElementById('timer-bar').style.width = width + '%';
            if (width <= 0) {
                currentQ++;
                nextQuestion();
            }
        }, 100); // 10 секунд на вопрос
    }

    // Запуск первой игры
    nextQuestion();
</script>
@endsection