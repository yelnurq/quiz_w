@extends('layouts.app')

@section('title', 'Собери компьютер | Игра')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

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
            <div class="space-y-4" id="names-column">
                <p class="text-center text-xs font-black uppercase tracking-widest text-gray-400 mb-4">Названия</p>
                </div>

            <div class="space-y-4" id="descriptions-column">
                <p class="text-center text-xs font-black uppercase tracking-widest text-gray-400 mb-4">Что это делает?</p>
                </div>
        </div>

        <div class="mt-12 text-center border-t border-gray-100 pt-8">
            <button onclick="startGame()" class="bg-gray-900 hover:bg-indigo-600 text-white px-10 py-4 rounded-2xl font-black transition-all shadow-xl active:scale-95 uppercase tracking-widest text-sm">
                Начать заново
            </button>
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
        
        const namesCol = document.getElementById('names-column');
        const descCol = document.getElementById('descriptions-column');

        // Перемешиваем массивы для случайного порядка
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
            // Успех!
            selectedName.el.classList.replace('bg-blue-50', 'bg-green-100');
            selectedName.el.classList.add('matched', 'border-green-500', 'text-green-700');
            el.classList.add('matched', 'bg-green-100', 'border-green-500', 'text-green-700');
            
            score += 10;
            matchedCount++;
            document.getElementById('score').innerText = score;
            selectedName = null;

            if (matchedCount === items.length) {
                confetti({ particleCount: 150, spread: 70, origin: { y: 0.6 } });
            }
        } else {
            // Ошибка
            el.classList.add('border-red-500', 'bg-red-50');
            setTimeout(() => {
                el.classList.remove('border-red-500', 'bg-red-50');
            }, 500);
            score = Math.max(0, score - 2);
            document.getElementById('score').innerText = score;
        }
    }

    document.addEventListener('DOMContentLoaded', startGame);
</script>

<style>
    .matched {
        cursor: default;
        opacity: 0.7;
    }
</style>
@endsection