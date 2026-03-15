@extends('layouts.app')

@section('title', 'Собери компьютер | Игра')
@section('game_name', 'Мастер Сборки ПК')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>

<style>
    .matched {
        cursor: default;
        opacity: 0.7;
    }
    
    /* Стили сертификата */
    .cert-border {
        border: 15px solid #1e3a8a;
        outline: 2px solid #1e3a8a;
        outline-offset: -20px;
        box-sizing: border-box;
    }
    
    /* Контейнер для печати: изначально скрыт */
    #cert-to-print {
        display: none;
        width: 1120px; 
        height: 790px;
        background: white;
    }

    .cert-preview-container {
        background: white;
        width: 100%;
        max-width: 900px;
        position: relative;
    }
</style>

<div class="max-w-5xl mx-auto">
    <div class="mb-8 flex flex-col md:flex-row justify-between items-center gap-4">
        <a href="{{ route('dashboard') }}" class="group flex items-center gap-2 text-gray-600 hover:text-blue-600 transition-colors font-bold">
            <div class="bg-white p-2 rounded-xl shadow-sm group-hover:shadow-md transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
            </div>
            Назад в меню
        </a>
        <div class="flex gap-4">
            <div class="bg-white/80 backdrop-blur-sm px-6 py-2 rounded-2xl shadow-sm border border-white font-black text-gray-700">
                ⭐ Очки: <span id="score" class="text-blue-600">0</span>
            </div>
        </div>
    </div>

    <div class="bg-white/70 backdrop-blur-md rounded-[2.5rem] shadow-2xl border border-white p-8 md:p-12">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-black uppercase text-gray-800">Мастер Сборки ПК 🛠️</h2>
            <p class="text-gray-500 font-medium mt-2">Соедини название детали с её описанием!</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12">
            <div class="space-y-4" id="names-column"></div>
            <div class="space-y-4" id="descriptions-column"></div>
        </div>

        <div class="mt-12 text-center border-t border-gray-100 pt-8">
            <button onclick="startGame()" class="bg-gray-900 hover:bg-indigo-600 text-white px-10 py-4 rounded-2xl font-black transition-all shadow-xl active:scale-95 uppercase tracking-widest text-sm">
                Начать заново
            </button>
        </div>
    </div>
</div>

<div id="modal" class="fixed inset-0 bg-gray-900/90 backdrop-blur-md hidden flex items-center justify-center p-4 z-50">
    <div class="bg-white p-12 rounded-[3rem] max-w-sm w-full text-center shadow-2xl border-4 border-white">
        <div class="text-8xl mb-6">🏆</div>
        <h3 class="text-4xl font-black mb-3 text-green-500">Браво!</h3>
        <p class="text-gray-500 text-lg mb-6 leading-relaxed">
            Ты собрал компьютер без единой заминки! Твой результат: <span id="final-score" class="font-bold text-blue-600"></span> очков.
        </p>
        <button onclick="showCertificate()" class="w-full mb-4 text-blue-600 font-black border-b-2 border-blue-600 hover:text-blue-800 transition-all uppercase text-sm tracking-widest">
            📜 Получить сертификат
        </button>
        <button onclick="startGame()" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-5 rounded-2xl font-black shadow-lg transition-all active:scale-95 uppercase tracking-widest text-sm">Играть ещё!</button>
    </div>
</div>

<div id="certificate-overlay" class="fixed inset-0 bg-black/80 backdrop-blur-md hidden flex flex-col items-center justify-center p-4 z-[60]">
    <div class="cert-preview-container rounded-lg shadow-2xl overflow-hidden mb-6">
        <div class="cert-border p-8 md:p-16 text-center bg-white relative">
            <div class="absolute top-0 left-0 w-32 h-32 bg-blue-600 -translate-x-16 -translate-y-16 rotate-45"></div>
            <h1 class="text-blue-900 text-4xl md:text-6xl font-black mb-4 uppercase">Сертификат</h1>
            <p class="text-gray-500 text-lg italic mb-8">Настоящим подтверждается, что</p>
            <h2 class="text-3xl md:text-5xl font-black text-gray-900 border-b-4 border-blue-600 inline-block px-8 pb-2 mb-8 uppercase italic">
                {{ auth()->user()->name }}
            </h2>
            <p class="text-gray-700 text-lg leading-relaxed max-w-2xl mx-auto mb-10">
                Успешно прошел испытание в игре <span class="font-bold text-blue-600">"@yield('game_name')"</span>, проявив выдающуюся смекалку и знания ИТ.
            </p>
            <div class="flex justify-between items-end px-10">
                <div class="text-left text-sm">
                    <p class="text-gray-400 font-bold uppercase tracking-widest">Дата</p>
                    <p class="text-gray-900 font-bold">{{ date('d.m.Y') }}</p>
                </div>
                <div class="bg-blue-600 text-white p-4 rounded-full font-black text-lg w-20 h-20 flex items-center justify-center rotate-12 border-4 border-white">IT-OK</div>
            </div>
        </div>
    </div>
    <div class="flex gap-4">
        <button onclick="downloadPDF()" id="pdf-btn" class="bg-green-600 hover:bg-green-700 text-white px-10 py-4 rounded-2xl font-black shadow-xl flex items-center gap-3 transition-all active:scale-95">
            <span>⬇️ СКАЧАТЬ PDF</span>
        </button>
        <button onclick="document.getElementById('certificate-overlay').classList.add('hidden')" class="bg-white/20 hover:bg-white/30 text-white px-10 py-4 rounded-2xl font-bold transition-all">
            Закрыть
        </button>
    </div>
</div>

<div id="cert-to-print">
    <div class="cert-border p-20 text-center bg-white relative h-full flex flex-col justify-center items-center">
        <div class="absolute top-0 left-0 w-48 h-48 bg-blue-600 -translate-x-24 -translate-y-24 rotate-45"></div>
        <h1 class="text-blue-900 text-8xl font-black mb-6 uppercase tracking-tighter">Сертификат</h1>
        <p class="text-gray-400 text-3xl font-medium mb-12 italic">Настоящим подтверждается, что</p>
        <h2 class="text-7xl font-black text-gray-900 border-b-8 border-blue-600 inline-block px-12 pb-4 uppercase italic mb-12">
            {{ auth()->user()->name }}
        </h2>
        <p class="text-gray-700 text-3xl leading-relaxed max-w-4xl mx-auto mb-16">
            Успешно прошел испытание в игре <span class="font-bold text-blue-600">"@yield('game_name')"</span>, 
            проявив выдающуюся смекалку и знание основ информационных технологий.
        </p>
        <div class="flex justify-between items-end w-full px-20">
            <div class="text-left">
                <p class="text-2xl text-gray-400 font-bold uppercase tracking-widest">Дата выдачи</p>
                <p class="text-gray-900 text-4xl font-black">{{ date('d.m.Y') }}</p>
            </div>
            <div class="bg-blue-600 text-white p-12 rounded-full font-black text-4xl w-40 h-40 flex items-center justify-center rotate-12 shadow-2xl border-8 border-white">IT-OK</div>
        </div>
    </div>
</div>

<script>
    const items = [
        { id: 1, name: 'Процессор', desc: '«Мозг» компьютера, выполняет все команды.', icon: '🧠' },
        { id: 2, name: 'Монитор', desc: 'Показывает нам картинки, видео и текст.', icon: '🖥️' },
        { id: 3, name: 'Мышка', desc: 'Помогает нам управлять курсором на экране.', icon: '🖱️' },
        { id: 4, name: 'Клавиатура', desc: 'Нужна для ввода текста и команд буквами.', icon: '⌨️' },
        { id: 5, name: 'Видеокарта', desc: 'Отвечает за запуск крутых игр и графику.', icon: '🎮' },
        { id: 6, name: 'Жесткий диск', desc: 'Место, где вечно хранятся все файлы и фото.', icon: '💾' },
        { id: 7, name: 'Принтер', desc: 'Переносит текст из компьютера на бумагу.', icon: '🖨️' }
    ];

    let selectedName = null;
    let score = 0;
    let matchedCount = 0;

    function startGame() {
        score = 0;
        matchedCount = 0;
        selectedName = null;
        document.getElementById('score').innerText = score;
        document.getElementById('modal').classList.add('hidden');
        document.getElementById('certificate-overlay').classList.add('hidden');
        
        const namesCol = document.getElementById('names-column');
        const descCol = document.getElementById('descriptions-column');

        const shuffledNames = [...items].sort(() => Math.random() - 0.5);
        const shuffledDescs = [...items].sort(() => Math.random() - 0.5);

        namesCol.innerHTML = '<p class="text-center text-xs font-black uppercase tracking-widest text-gray-400 mb-4">Названия</p>';
        descCol.innerHTML = '<p class="text-center text-xs font-black uppercase tracking-widest text-gray-400 mb-4">Что это делает?</p>';

        shuffledNames.forEach(item => {
            namesCol.innerHTML += `
                <button onclick="selectName(this, ${item.id})" class="name-btn w-full bg-white p-4 rounded-2xl border-2 border-transparent shadow-sm hover:shadow-md transition-all font-bold text-gray-700 text-left flex items-center gap-3">
                    <span class="text-2xl">${item.icon}</span> ${item.name}
                </button>
            `;
        });

        shuffledDescs.forEach(item => {
            descCol.innerHTML += `
                <button onclick="selectDesc(this, ${item.id})" class="desc-btn w-full bg-white p-4 rounded-2xl border-2 border-transparent shadow-sm hover:shadow-md transition-all text-sm font-medium text-gray-600 text-left">
                    ${item.desc}
                </button>
            `;
        });
    }

    function selectName(el, id) {
        if (el.classList.contains('matched')) return;
        document.querySelectorAll('.name-btn').forEach(b => b.classList.remove('border-blue-500', 'bg-blue-50'));
        el.classList.add('border-blue-500', 'bg-blue-50');
        selectedName = { el, id };
    }

    function selectDesc(el, id) {
        if (!selectedName || el.classList.contains('matched')) return;

        if (selectedName.id === id) {
            selectedName.el.classList.replace('bg-blue-50', 'bg-green-100');
            selectedName.el.classList.add('matched', 'border-green-500', 'text-green-700');
            el.classList.add('matched', 'bg-green-100', 'border-green-500', 'text-green-700');
            
            score += 10;
            matchedCount++;
            document.getElementById('score').innerText = score;
            selectedName = null;

            if (matchedCount === items.length) {
                confetti({ particleCount: 150, spread: 70, origin: { y: 0.6 } });
                setTimeout(() => {
                    document.getElementById('final-score').innerText = score;
                    document.getElementById('modal').classList.remove('hidden');
                }, 800);
            }
        } else {
            el.classList.add('border-red-500', 'bg-red-50');
            setTimeout(() => el.classList.remove('border-red-500', 'bg-red-50'), 500);
            score = Math.max(0, score - 2);
            document.getElementById('score').innerText = score;
        }
    }

    function showCertificate() {
        document.getElementById('modal').classList.add('hidden');
        document.getElementById('certificate-overlay').classList.remove('hidden');
    }

    function downloadPDF() {
        const element = document.getElementById('cert-to-print');
        const btn = document.getElementById('pdf-btn');
        
        btn.innerHTML = '<span>⏳ ГЕНЕРАЦИЯ...</span>';
        btn.disabled = true;

        element.style.display = 'block';
        element.style.position = 'fixed';
        element.style.left = '0';
        element.style.top = '0';
        element.style.zIndex = '-1';

        const opt = {
            margin: 0,
            filename: 'Certificate_PC_Master.pdf',
            image: { type: 'jpeg', quality: 0.98 },
            html2canvas: { 
                scale: 2, 
                useCORS: true,
                logging: false,
                letterRendering: true
            },
            jsPDF: { unit: 'mm', format: 'a4', orientation: 'landscape' }
        };

        html2pdf().set(opt).from(element).save().then(() => {
            element.style.display = 'none';
            btn.innerHTML = '<span>⬇️ СКАЧАТЬ PDF</span>';
            btn.disabled = false;
        });
    }

    document.addEventListener('DOMContentLoaded', startGame);
</script>
@endsection