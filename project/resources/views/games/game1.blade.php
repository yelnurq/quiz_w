@extends('layouts.app')

@section('title', 'IT-Ребус | Играть')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>
    .cert-border {
        border: 15px solid #1e3a8a;
        outline: 2px solid #1e3a8a;
        outline-offset: -20px;
    }
    /* Стили для PDF-генератора */
    .pdf-container {
        width: 1120px; /* Стандарт для A4 Landscape */
        height: 790px;
        background: white;
        margin: 0;
        padding: 20px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>

<div class="max-w-4xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('dashboard') }}" class="group flex items-center gap-2 text-gray-600 hover:text-blue-600 transition-colors font-bold">
            <div class="bg-white p-2 rounded-xl shadow-sm group-hover:shadow-md transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
            </div>
            Назад в меню
        </a>
        <div class="bg-white/80 backdrop-blur-sm px-5 py-2 rounded-2xl shadow-sm border border-white font-black text-gray-700">
            🕹️ Игрок: <span class="text-blue-600 uppercase">{{ explode(' ', auth()->user()->name)[0] }}</span>
        </div>
    </div>

    <div class="bg-white/70 backdrop-blur-md rounded-[2.5rem] shadow-2xl overflow-hidden border border-white">
        <div class="bg-gradient-to-r from-blue-600 to-indigo-600 p-8 text-white text-center">
            <h2 class="text-3xl font-black uppercase tracking-tighter">IT-Ребус</h2>
            <p class="mt-1 opacity-90 font-medium">Сможешь угадать слово без ошибок?</p>
        </div>
        <div class="p-8 md:p-12">
            <div class="flex flex-col md:flex-row justify-between items-center gap-6 mb-12">
                <div class="bg-white px-8 py-4 rounded-3xl shadow-inner border border-gray-100 w-full md:w-auto text-center">
                    <p class="text-xs uppercase font-black text-gray-400 tracking-widest mb-1">Ошибки</p>
                    <div class="text-2xl font-black">
                        <span id="mistakes" class="text-red-500">0</span> <span class="text-gray-300">/</span> 6
                    </div>
                </div>
                <div id="hint-box" class="bg-blue-50/50 text-blue-900 px-8 py-5 rounded-3xl text-lg font-medium border border-blue-100 w-full md:w-2/3 flex items-center gap-4">
                    <span class="text-3xl">💡</span>
                    <p id="hint" class="leading-tight">...</p>
                </div>
            </div>
            <div id="word-display" class="flex flex-wrap justify-center gap-4 mb-16 text-4xl md:text-6xl font-black text-blue-900 drop-shadow-sm min-h-[80px]"></div>
            <div id="keyboard" class="grid grid-cols-6 sm:grid-cols-8 md:grid-cols-11 gap-2 md:gap-3 mb-12"></div>
            <div class="flex justify-center border-t border-gray-100 pt-10">
                <button onclick="initGame()" class="bg-gray-900 hover:bg-blue-600 text-white px-12 py-5 rounded-2xl font-black transition-all shadow-xl hover:-translate-y-1 active:scale-95 flex items-center gap-3 uppercase tracking-widest text-sm">Новое слово</button>
            </div>
        </div>
    </div>
</div>

<div id="modal" class="fixed inset-0 bg-gray-900/90 backdrop-blur-md hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white p-12 rounded-[3rem] max-w-sm w-full text-center shadow-2xl border-4 border-white">
        <div id="modal-icon" class="text-8xl mb-6"></div>
        <h3 id="modal-title" class="text-4xl font-black mb-3"></h3>
        <p id="modal-msg" class="text-gray-500 text-lg mb-10 leading-relaxed"></p>
        <button onclick="initGame()" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-5 rounded-2xl font-black shadow-lg shadow-blue-200 transition-all active:scale-95 uppercase tracking-widest text-sm">Играть ещё!</button>
    </div>
</div>

<div id="certificate-overlay" class="fixed inset-0 bg-black/80 backdrop-blur-md hidden flex items-center justify-center p-4 z-[60]">
    <div class="bg-white p-4 rounded-xl shadow-2xl max-w-5xl w-full relative">
        <button onclick="document.getElementById('certificate-overlay').classList.add('hidden')" class="absolute -top-12 right-0 text-white hover:text-blue-300 transition-colors font-bold uppercase tracking-widest text-sm">✕ Закрыть</button>

        <div id="cert-to-print" class="bg-white">
            <div class="cert-border p-16 text-center relative overflow-hidden bg-white" style="min-height: 600px;">
                <div class="absolute top-0 left-0 w-32 h-32 bg-blue-600 -translate-x-16 -translate-y-16 rotate-45"></div>
                <div class="relative z-10">
                    <h1 class="text-blue-900 text-6xl font-black mb-4 uppercase tracking-tighter">Сертификат</h1>
                    <p class="text-gray-500 text-2xl font-medium mb-12 italic">Настоящим подтверждается, что</p>
                    <div class="mb-10">
                        <h2 id="cert-user-name" class="text-5xl font-black text-gray-900 border-b-8 border-blue-600 inline-block px-12 pb-2 uppercase italic">
                            {{ auth()->user()->name }}
                        </h2>
                    </div>
                    <p class="text-gray-700 text-2xl leading-relaxed max-w-2xl mx-auto mb-16 font-medium">
                        Успешно прошел испытание в игре <span class="font-bold text-blue-600">"IT-Ребус"</span>, 
                        проявив выдающуюся смекалку и знание основ информационных технологий.
                    </p>
                    <div class="flex justify-between items-end mt-20 px-10">
                        <div class="text-left">
                            <div class="w-48 border-b-2 border-gray-300 mb-2"></div>
                            <p class="text-sm text-gray-400 font-bold uppercase tracking-widest">Дата выдачи</p>
                            <p class="text-gray-900 text-xl font-bold">{{ date('d.m.Y') }}</p>
                        </div>
                        <div class="bg-blue-600 text-white p-6 rounded-full font-black text-2xl w-32 h-32 flex items-center justify-center rotate-12 shadow-lg border-4 border-white">IT-OK</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-6 flex justify-center gap-4">
            <button onclick="downloadPDF()" class="bg-green-600 hover:bg-green-700 text-white px-10 py-4 rounded-2xl font-black transition-all flex items-center gap-3 shadow-lg uppercase tracking-widest text-sm">
                ⬇️ Скачать PDF
            </button>
        </div>
    </div>
</div>

<script>
    const words = [
        { word: 'МОНИТОР', hint: 'Экран, на котором мы видим картинку и текст' },
        { word: 'МЫШКА', hint: 'Устройство, которым мы двигаем курсор на экране' },
        { word: 'КЛАВИАТУРА', hint: 'На ней много кнопок с буквами и цифрами' },
        { word: 'ИНТЕРНЕТ', hint: 'Всемирная сеть, где можно найти информацию' },
        { word: 'АЛГОРИТМ', hint: 'Четкий план действий для решения задачи' },
        { word: 'ПАРОЛЬ', hint: 'Секретный код для защиты твоего аккаунта' },
        { word: 'ПРОГРАММА', hint: 'Набор команд, которые выполняет компьютер' },
        { word: 'ПРИНТЕР', hint: 'Устройство, которое печатает текст на бумагу' },
        { word: 'РОБОТ', hint: 'Машина, которая умеет выполнять команды' },
        { word: 'ФАЙЛ', hint: 'Документ или картинка в компьютере' },
        { word: 'ПАМЯТЬ', hint: 'Место, где компьютер хранит информацию' },
        { word: 'КУРСОР', hint: 'Стрелочка, которая бегает по экрану' }
    ];

    let selectedWord = "";
    let guessedLetters = [];
    let mistakes = 0;
    const maxMistakes = 6;

    function initGame() {
        const item = words[Math.floor(Math.random() * words.length)];
        selectedWord = item.word;
        guessedLetters = [];
        mistakes = 0;
        document.getElementById('hint').innerText = item.hint;
        document.getElementById('mistakes').innerText = mistakes;
        document.getElementById('modal').classList.add('hidden');
        document.getElementById('certificate-overlay').classList.add('hidden');
        updateWordDisplay();
        createKeyboard();
    }

    function updateWordDisplay() {
        const wordArr = selectedWord.split('');
        const display = wordArr.map(letter => {
            const isGuessed = guessedLetters.includes(letter);
            return `<div class="flex flex-col items-center">
                <span class="transition-all duration-500 ${isGuessed ? 'translate-y-0 opacity-100' : 'translate-y-4 opacity-0'} h-12 md:h-16 flex items-center justify-center font-black">${isGuessed ? letter : ''}</span>
                <div class="h-2 w-8 md:w-12 bg-blue-100 rounded-full mt-1 ${isGuessed ? 'bg-blue-500' : ''}"></div>
            </div>`;
        }).join('');
        document.getElementById('word-display').innerHTML = display;
        if (wordArr.every(l => guessedLetters.includes(l))) {
            fireConfetti();
            setTimeout(() => endGame(true), 600);
        }
    }

    function createKeyboard() {
        const letters = "АБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯ";
        const keyboard = document.getElementById('keyboard');
        keyboard.innerHTML = letters.split('').map(l => 
            `<button onclick="handleGuess('${l}')" id="key-${l}" class="bg-gray-50 hover:bg-blue-500 hover:text-white h-12 md:h-14 rounded-xl font-black transition-all border border-gray-100 shadow-sm active:scale-90 flex items-center justify-center text-sm md:text-base">${l}</button>`
        ).join('');
    }

    function handleGuess(letter) {
        if (guessedLetters.includes(letter) || mistakes >= maxMistakes) return;
        guessedLetters.push(letter);
        const btn = document.getElementById(`key-${letter}`);
        if (selectedWord.includes(letter)) {
            btn.classList.add('bg-green-500', 'text-white', 'border-green-600');
            updateWordDisplay();
        } else {
            mistakes++;
            btn.classList.add('bg-red-100', 'text-red-300', 'border-red-50');
            document.getElementById('mistakes').innerText = mistakes;
            if (mistakes >= maxMistakes) setTimeout(() => endGame(false), 400);
        }
        btn.onclick = null;
    }

    function fireConfetti() {
        confetti({ particleCount: 150, spread: 70, origin: { y: 0.6 }, colors: ['#2563eb', '#4f46e5', '#fbbf24', '#10b981'] });
    }

    function endGame(isWin) {
        const modal = document.getElementById('modal');
        document.getElementById('modal-icon').innerText = isWin ? "🏆" : "🔌";
        document.getElementById('modal-title').innerText = isWin ? "Умница!" : "Упс!";
        document.getElementById('modal-title').className = `text-4xl font-black mb-3 ${isWin ? 'text-green-500' : 'text-orange-500'}`;
        let msg = isWin ? "Ты настоящий айтишник! Слово разгадано верно." : `Компьютер выключился! Правильное слово: <br><b class="text-gray-900 text-2xl uppercase tracking-widest">${selectedWord}</b>`;
        if(isWin) msg += `<br><button onclick="showCertificate()" class="mt-6 text-blue-600 font-black border-b-2 border-blue-600 hover:text-blue-800 transition-all uppercase text-sm tracking-widest">📜 Скачать сертификат</button>`;
        document.getElementById('modal-msg').innerHTML = msg;
        modal.classList.remove('hidden');
    }

    function showCertificate() {
        document.getElementById('modal').classList.add('hidden');
        document.getElementById('certificate-overlay').classList.remove('hidden');
    }

    function downloadPDF() {
        const element = document.getElementById('cert-to-print');
        const options = {
            margin: 0,
            filename: `IT-Cert-{{ auth()->user()->id }}.pdf`,
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { scale: 2, logging: false, useCORS: true },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' } // АВТОМАТИЧЕСКИЙ ГОРИЗОНТАЛЬНЫЙ РЕЖИМ
        };

        // Запускаем сохранение
        html2pdf().set(options).from(element).save();
    }

    document.addEventListener('keydown', (e) => {
        let key = e.key.toUpperCase();
        const enToRu = { "Q":"Й","W":"Ц","E":"У","R":"К","T":"Е","Y":"Н","U":"Г","I":"Ш","O":"Щ","P":"З","[":"Х","]":"Ъ","A":"Ф","S":"Ы","D":"В","F":"А","G":"П","H":"Р","J":"О","K":"Л","L":"Д",";":"Ж","'":"Э","Z":"Я","X":"Ч","C":"С","V":"М","B":"И","N":"Т","M":"Ь",",":"Б",".":"Ю" };
        const finalKey = enToRu[key] || key;
        if (/^[А-ЯЁ]$/.test(finalKey)) handleGuess(finalKey);
    });

    document.addEventListener('DOMContentLoaded', initGame);
</script>
@endsection