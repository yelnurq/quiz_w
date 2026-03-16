@extends('layouts.app')

@section('title', 'Кибер-Патруль | Игра')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<div class="max-w-2xl mx-auto">
    <div class="mb-6 flex items-center justify-between">
        <a href="{{ route('dashboard') }}" class="group flex items-center gap-2 text-gray-600 hover:text-blue-600 transition-colors font-bold">
            <div class="bg-white p-2 rounded-xl shadow-sm group-hover:shadow-md transition-all">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd" d="M9.707 16.707a1 1 0 01-1.414 0l-6-6a1 1 0 010-1.414l6-6a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l4.293 4.293a1 1 0 010 1.414z" clip-rule="evenodd" />
                </svg>
            </div>
            В меню
        </a>
        <div class="bg-white/80 backdrop-blur-sm px-4 py-2 rounded-2xl shadow-sm border border-white font-black text-gray-700">
            🛡️ Уровень защиты: <span id="health" class="text-green-500">100%</span>
        </div>
    </div>

    <div class="bg-slate-900 rounded-[3rem] p-4 shadow-2xl border-[8px] border-slate-800 relative overflow-hidden aspect-[9/16] max-h-[700px] flex flex-col">
        <div class="flex justify-between px-6 py-2 text-white/50 text-xs font-bold">
            <span>9:41</span>
            <div class="flex gap-1">
                <span>📶</span><span>🔋</span>
            </div>
        </div>

        <div class="flex-1 p-4 overflow-y-auto space-y-4 flex flex-col justify-end" id="chat-container">
            </div>

        <div id="action-buttons" class="p-6 bg-slate-800/50 backdrop-blur-md rounded-t-[2rem] grid grid-cols-2 gap-4 translate-y-0 transition-transform duration-500">
            <button onclick="handleChoice(false)" class="bg-red-500 hover:bg-red-600 text-white py-4 rounded-2xl font-black shadow-lg shadow-red-900/20 active:scale-95 transition-all uppercase text-xs tracking-widest">
                Блокировать ❌
            </button>
            <button onclick="handleChoice(true)" class="bg-green-500 hover:bg-green-600 text-white py-4 rounded-2xl font-black shadow-lg shadow-green-900/20 active:scale-95 transition-all uppercase text-xs tracking-widest">
                Доверять ✅
            </button>
        </div>
    </div>
</div>

<div id="result-modal" class="fixed inset-0 bg-slate-900/95 backdrop-blur-xl hidden flex items-center justify-center p-6 z-50">
    <div class="text-center text-white max-w-sm">
        <div id="final-icon" class="text-8xl mb-6"></div>
        <h3 id="final-title" class="text-4xl font-black mb-4"></h3>
        <p id="final-msg" class="text-slate-400 mb-8 leading-relaxed"></p>
        <button onclick="location.reload()" class="w-full bg-blue-600 py-5 rounded-2xl font-black hover:bg-blue-700 transition-all shadow-xl">
            Попробовать снова
        </button>
    </div>
</div>

<script>
    const scenarios = [
        { text: "Привет! Это твоя классная руководительница. Пришли, пожалуйста, номер карты мамы для оплаты обедов.", isSafe: false, sender: "Учительница (???)", icon: "👩‍🏫" },
        { text: "Смотри, какие фотки с сегодняшней физкультуры! 😂", isSafe: true, sender: "Друг Димаш", icon: "👦" },
        { text: "ПОЗДРАВЛЯЕМ! Вы выиграли iPhone 16! Перейдите по ссылке, чтобы забрать приз: bit.ly/free-phone", isSafe: false, sender: "Служба Подарков", icon: "🎁" },
        { text: "Завтра информатика во втором кабинете, не забудь флешку.", isSafe: true, sender: "Одноклассница Аружан", icon: "👧" },
        { text: "Я администратор Roblox. Нам нужно проверить твой аккаунт. Напиши свой пароль в ответном сообщении.", isSafe: false, sender: "Roblox Admin", icon: "🎮" },
        { text: "Мама просила передать, что заберет тебя сегодня пораньше. Будь на связи!", isSafe: true, sender: "Папа", icon: "🧔" },
        { text: "Твой аккаунт взломан! Срочно скачай этот файл-антивирус, иначе всё удалится!", isSafe: false, sender: "System Security", icon: "⚠️" }
    ];

    let currentStep = 0;
    let health = 100;
    const chatContainer = document.getElementById('chat-container');

    function addMessage(text, sender, icon) {
        const msgHtml = `
            <div class="flex flex-col items-start space-y-1 animate-fadeIn">
                <span class="text-[10px] font-black text-white/30 ml-2 uppercase tracking-tighter">${sender}</span>
                <div class="bg-slate-700 text-white p-4 rounded-2xl rounded-tl-none max-w-[85%] shadow-sm border border-white/5 relative">
                    <span class="absolute -left-10 top-0 text-2xl">${icon}</span>
                    ${text}
                </div>
            </div>
        `;
        chatContainer.innerHTML += msgHtml;
        chatContainer.scrollTop = chatContainer.scrollHeight;
    }

    function handleChoice(isTrust) {
        const currentScenario = scenarios[currentStep];
        const isCorrect = isTrust === currentScenario.isSafe;

        if (!isCorrect) {
            health -= 25;
            document.getElementById('health').innerText = health + '%';
            document.getElementById('health').className = health < 50 ? 'text-red-500' : 'text-orange-500';
            // Эффект встряски экрана
            document.querySelector('.bg-slate-900').classList.add('animate-shake');
            setTimeout(() => document.querySelector('.bg-slate-900').classList.remove('animate-shake'), 500);
        }

        currentStep++;

        if (health <= 0) {
            endGame(false);
        } else if (currentStep >= scenarios.length) {
            endGame(true);
        } else {
            // Очищаем старые и добавляем следующее
            setTimeout(() => {
                addMessage(scenarios[currentStep].text, scenarios[currentStep].sender, scenarios[currentStep].icon);
            }, 300);
        }
    }

    function endGame(isWin) {
        const modal = document.getElementById('result-modal');
        const icon = document.getElementById('final-icon');
        const title = document.getElementById('final-title');
        const msg = document.getElementById('final-msg');

        modal.classList.remove('hidden');
        if (isWin) {
            confetti({ particleCount: 150, spread: 70, origin: { y: 0.6 } });
            icon.innerText = "🕵️‍♂️";
            title.innerText = "Кибер-Агент!";
            msg.innerText = "Ты отлично разбираешься в безопасности! Ни один мошенник не смог тебя обмануть.";
        } else {
            icon.innerText = "👾";
            title.innerText = "Взлом!";
            msg.innerText = "Ой-ой! Твои данные попали в руки злоумышленников. Помни: никогда не передавай пароли и не переходи по подозрительным ссылкам.";
        }
    }

    // Запуск первого сообщения
    setTimeout(() => {
        addMessage(scenarios[0].text, scenarios[0].sender, scenarios[0].icon);
    }, 500);
</script>

<style>
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .animate-fadeIn { animation: fadeIn 0.4s ease-out forwards; }
    
    @keyframes shake {
        0%, 100% { transform: translateX(0); }
        25% { transform: translateX(-10px); }
        75% { transform: translateX(10px); }
    }
    .animate-shake { animation: shake 0.2s ease-in-out 2; }
</style>
@endsection