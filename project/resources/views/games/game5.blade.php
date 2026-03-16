@extends('layouts.app')

@section('title', 'Скоростной Математик | Игра')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<div class="max-w-4xl mx-auto">
    <div class="mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
        <a href="{{ route('dashboard') }}" class="group flex items-center gap-2 text-gray-600 hover:text-yellow-600 transition-colors font-bold">
            <div class="bg-white p-2 rounded-xl shadow-sm group-hover:shadow-md transition-all text-xs">⬅ Назад</div>
            В меню
        </a>
        <div class="flex gap-4">
            <div class="bg-white px-6 py-2 rounded-2xl shadow-sm border-2 border-yellow-400 font-black text-yellow-600">
                Очки: <span id="score">0</span>
            </div>
            <div class="bg-white px-6 py-2 rounded-2xl shadow-sm border-2 border-red-400 font-black text-red-600">
                Время: <span id="timer">05.0</span>
            </div>
        </div>
    </div>

    <div id="game-container" class="bg-white rounded-[3rem] p-8 md:p-12 shadow-2xl border-4 border-white relative overflow-hidden min-h-[400px] flex flex-col items-center justify-center text-center">
        
        <div id="start-screen" class="z-10">
            <span class="text-8xl mb-6 block">⚡</span>
            <h2 class="text-4xl font-black text-gray-800 mb-4 uppercase tracking-tighter">Скоростной Математик</h2>
            <p class="text-gray-500 font-medium mb-8 max-w-sm mx-auto">Решай примеры за отведенное время. С каждым правильным ответом темп ускоряется!</p>
            <button onclick="startGame()" class="bg-yellow-500 hover:bg-yellow-600 text-white px-12 py-5 rounded-3xl font-black text-xl shadow-xl shadow-yellow-100 transition-all hover:scale-105 active:scale-95 uppercase">
                Поехали! ▶️
            </button>
        </div>

        <div id="play-screen" class="hidden w-full z-10">
            <div id="problem" class="text-7xl md:text-8xl font-black text-gray-900 mb-12 tracking-tighter">
                2 + 2
            </div>
            <div id="options" class="grid grid-cols-2 gap-4 max-w-md mx-auto">
                </div>
        </div>

        <div class="absolute top-0 left-0 w-full h-2 bg-gray-100">
            <div id="progress-bar" class="h-full bg-yellow-400 transition-all duration-100 linear" style="width: 100%"></div>
        </div>
    </div>
</div>

<script>
    let score = 0;
    let timeLeft = 5.0;
    let timerInterval;
    let currentAnswer;
    let difficulty = 5.0; // Начальное время на ответ

    function startGame() {
        score = 0;
        difficulty = 5.0;
        document.getElementById('score').innerText = score;
        document.getElementById('start-screen').classList.add('hidden');
        document.getElementById('play-screen').classList.remove('hidden');
        nextProblem();
    }

    function nextProblem() {
        clearInterval(timerInterval);
        
        // Оставляем только плюс и минус
        const operators = ['+', '-'];
        const op = operators[Math.floor(Math.random() * operators.length)];
        
        let n1, n2;

        if (op === '+') {
            // Для плюса берем любые числа до 50
            n1 = Math.floor(Math.random() * 50) + 1;
            n2 = Math.floor(Math.random() * 50) + 1;
        } else {
            // Для минуса: сначала генерируем два числа
            let a = Math.floor(Math.random() * 50) + 1;
            let b = Math.floor(Math.random() * 50) + 1;
            
            // Чтобы не было минусовых, n1 всегда должен быть больше n2
            n1 = Math.max(a, b);
            n2 = Math.min(a, b);
        }

        // Вычисляем правильный ответ
        currentAnswer = op === '+' ? n1 + n2 : n1 - n2;
        
        // Выводим пример на экран
        document.getElementById('problem').innerText = `${n1} ${op} ${n2}`;

        generateOptions(currentAnswer);
        
        timeLeft = difficulty;
        startTimer();
    }

    function generateOptions(correct) {
        const optionsContainer = document.getElementById('options');
        optionsContainer.innerHTML = '';
        
        let choices = [correct];
        while(choices.length < 4) {
            let wrong = correct + (Math.floor(Math.random() * 10) - 5);
            if (!choices.includes(wrong)) choices.push(wrong);
        }
        
        choices.sort(() => Math.random() - 0.5);

        choices.forEach(val => {
            const btn = document.createElement('button');
            btn.className = "bg-gray-100 hover:bg-yellow-100 border-2 border-gray-200 hover:border-yellow-400 p-6 rounded-3xl text-2xl font-black text-gray-800 transition-all active:scale-90";
            btn.innerText = val;
            btn.onclick = () => checkAnswer(val);
            optionsContainer.appendChild(btn);
        });
    }

    function startTimer() {
        const timerDisplay = document.getElementById('timer');
        const progressBar = document.getElementById('progress-bar');
        
        const startTimestamp = Date.now();
        const endTimestamp = startTimestamp + (timeLeft * 1000);

        timerInterval = setInterval(() => {
            const now = Date.now();
            const remaining = Math.max(0, (endTimestamp - now) / 1000);
            
            timerDisplay.innerText = remaining.toFixed(1);
            progressBar.style.width = (remaining / difficulty * 100) + '%';

            if (remaining <= 0) {
                gameOver("Время вышло! ⏰");
            }
        }, 50);
    }

    function checkAnswer(selected) {
        if (selected === currentAnswer) {
            score++;
            document.getElementById('score').innerText = score;
            
            if (difficulty > 1.5) difficulty -= 0.15;
            
            const container = document.getElementById('game-container');
            container.classList.add('ring-8', 'ring-green-400', 'ring-inset');
            setTimeout(() => container.classList.remove('ring-8', 'ring-green-400', 'ring-inset'), 200);
            
            nextProblem();
        } else {
            gameOver("Ошибка! ❌");
        }
    }

    function gameOver(reason) {
        clearInterval(timerInterval);
        confetti({ particleCount: 50, spread: 30, origin: { y: 0.8 }, colors: ['#ef4444'] });
        
        alert(`${reason}\nТвой результат: ${score} очков.`);
        
        document.getElementById('start-screen').classList.remove('hidden');
        document.getElementById('play-screen').classList.add('hidden');
        document.getElementById('progress-bar').style.width = '100%';
        document.getElementById('timer').innerText = "05.0";
    }
</script>

<style>
    #problem { animation: popIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275); }
    @keyframes popIn {
        0% { transform: scale(0.5); opacity: 0; }
        100% { transform: scale(1); opacity: 1; }
    }
    .linear { transition-timing-function: linear !important; }
</style>
@endsection