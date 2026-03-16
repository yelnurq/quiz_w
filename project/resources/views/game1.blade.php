@extends('layouts.app')

@section('title', 'JS Ребус | Играть')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('dashboard') }}" class="text-blue-600 hover:text-blue-800 flex items-center gap-2 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd" d=" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
            </svg>
            Назад в меню
        </a>
        <div class="bg-white px-4 py-2 rounded-lg shadow-sm border font-bold text-gray-700">
            Игрок: <span class="text-blue-600">{{ auth()->user()->name }}</span>
        </div>
    </div>

    <div class="bg-white rounded-2xl shadow-xl overflow-hidden border border-gray-100">
        <div class="bg-blue-600 p-6 text-white text-center">
            <h2 class="text-2xl font-bold uppercase tracking-widest">JS Ребус</h2>
            <p class="mt-2 opacity-80">Угадай термин программирования по буквам</p>
        </div>

        <div class="p-8">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-10">
                <div class="text-lg font-medium text-gray-700 bg-gray-50 px-6 py-3 rounded-xl border w-full md:w-auto text-center">
                    Ошибки: <span id="mistakes" class="text-red-500 font-bold text-2xl ml-2">0</span> / 6
                </div>
                <div id="hint-box" class="bg-yellow-50 text-yellow-800 px-6 py-3 rounded-xl text-sm italic border border-yellow-200 w-full md:w-2/3 text-center md:text-left">
                    <strong>Подсказка:</strong> <span id="hint">...</span>
                </div>
            </div>

            <div id="word-display" class="flex flex-wrap justify-center gap-3 mb-12 text-3xl md:text-5xl font-mono font-bold text-blue-900 tracking-widest uppercase">
                </div>

            <div id="keyboard" class="grid grid-cols-7 sm:grid-cols-9 gap-2 mb-10">
                </div>

            <div class="flex justify-center border-t pt-8">
                <button onclick="initGame()" class="bg-gray-800 hover:bg-black text-white px-10 py-4 rounded-xl font-bold transition shadow-lg transform hover:scale-105 active:scale-95">
                    Новое слово
                </button>
            </div>
        </div>
    </div>
</div>

<div id="modal" class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white p-10 rounded-3xl max-w-sm w-full text-center shadow-2xl transform transition-all">
        <div id="modal-icon" class="text-6xl mb-4"></div>
        <h3 id="modal-title" class="text-3xl font-black mb-2"></h3>
        <p id="modal-msg" class="text-gray-600 mb-8"></p>
        <button onclick="initGame()" class="w-full bg-blue-600 text-white py-4 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg">
            Играть еще раз
        </button>
    </div>
</div>

<script>
const words = [
        { word: 'МОНИТОР', hint: 'Экран, на котором мы видим картинку и текст' },
        { word: 'МЫШКА', hint: 'Устройство, которым мы двигаем курсор на экране' },
        { word: 'КЛАВИАТУРА', hint: 'На ней много кнопок с буквами и цифрами' },
        { word: 'ИНТЕРНЕТ', hint: 'Всемирная сеть, где можно найти любую информацию' },
        { word: 'АЛГОРИТМ', hint: 'Четкий план действий для решения задачи' },
        { word: 'ПАРОЛЬ', hint: 'Секретный код для защиты твоего аккаунта' },
        { word: 'ПРОГРАММА', hint: 'Набор команд, которые выполняет компьютер' },
        { word: 'ПРИНТЕР', hint: 'Устройство, которое печатает текст на бумагу' },
        { word: 'РОБОТ', hint: 'Машина, которая умеет выполнять команды человека' },
        { word: 'ФАЙЛ', hint: 'Документ или картинка, сохраненная на компьютере' },
        { word: 'ПАМЯТЬ', hint: 'Место, где компьютер хранит всю информацию' },
        { word: 'КУРСОР', hint: 'Стрелочка, которая бегает по экрану за мышкой' }
    ];

    let selectedWord = "";
    let guessedLetters = [];
    let mistakes = 0;
    const maxMistakes = 6;

    function initGame() {
        // Выбор случайного слова
        const item = words[Math.floor(Math.random() * words.length)];
        selectedWord = item.word;
        guessedLetters = [];
        mistakes = 0;

        // Обновление интерфейса
        document.getElementById('hint').innerText = item.hint;
        document.getElementById('mistakes').innerText = mistakes;
        document.getElementById('modal').classList.add('hidden');
        
        updateWordDisplay();
        createKeyboard();
    }

    function updateWordDisplay() {
        const wordArr = selectedWord.split('');
        const display = wordArr.map(letter => {
            const isGuessed = guessedLetters.includes(letter);
            return `<span class="inline-block border-b-4 ${isGuessed ? 'border-blue-500 text-blue-600' : 'border-gray-200 text-transparent'} w-10 text-center transition-all duration-300">${isGuessed ? letter : '?'}</span>`;
        }).join('');
        
        document.getElementById('word-display').innerHTML = display;

        // Проверка победы (все ли буквы угаданы)
        const isWin = wordArr.every(letter => guessedLetters.includes(letter));
        if (isWin) {
            setTimeout(() => endGame(true), 300);
        }
    }

    function createKeyboard() {
        const letters = "QWERTYUIOPASDFGHJKLZXCVBNM";
        const keyboard = document.getElementById('keyboard');
        keyboard.innerHTML = letters.split('').map(l => 
            `<button onclick="handleGuess('${l}')" id="key-${l}" class="bg-white hover:bg-blue-50 p-3 rounded-lg font-bold transition border border-gray-200 shadow-sm text-gray-700 active:bg-blue-200 hover:border-blue-300">
                ${l}
            </button>`
        ).join('');
    }

    function handleGuess(letter) {
        if (guessedLetters.includes(letter) || mistakes >= maxMistakes) return;

        guessedLetters.push(letter);
        const btn = document.getElementById(`key-${letter}`);
        
        if (selectedWord.includes(letter)) {
            btn.classList.add('bg-green-100', 'text-green-700', 'border-green-300');
            updateWordDisplay();
        } else {
            mistakes++;
            btn.classList.add('bg-red-50', 'text-red-400', 'border-red-200', 'opacity-50');
            document.getElementById('mistakes').innerText = mistakes;
            if (mistakes >= maxMistakes) {
                setTimeout(() => endGame(false), 300);
            }
        }
        btn.disabled = true;
    }

    function endGame(isWin) {
        const modal = document.getElementById('modal');
        const title = document.getElementById('modal-title');
        const msg = document.getElementById('modal-msg');
        const icon = document.getElementById('modal-icon');

        modal.classList.remove('hidden');
        icon.innerText = isWin ? "🎉" : "💀";
        title.innerText = isWin ? "Победа!" : "Ой, всё...";
        title.className = isWin ? "text-3xl font-black mb-2 text-green-600" : "text-3xl font-black mb-2 text-red-600";
        msg.innerHTML = isWin ? 
            "Вы отлично справились с этим термином!" : 
            `Вы не угадали слово: <br><span class="text-xl font-bold text-gray-800 uppercase">${selectedWord}</span>`;
    }

    // Слушатель реальной клавиатуры (фишка для удобства)
    document.addEventListener('keydown', (e) => {
        const letter = e.key.toUpperCase();
        if (/^[A-Z]$/.test(letter)) {
            handleGuess(letter);
        }
    });

    // Запуск при загрузке страницы
    document.addEventListener('DOMContentLoaded', initGame);
</script>
@endsection