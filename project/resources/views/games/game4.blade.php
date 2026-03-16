@extends('layouts.app')

@section('title', 'Битва Роботов | Игра')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.6.0/dist/confetti.browser.min.js"></script>

<div class="max-w-5xl mx-auto">
    <div class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
        <a href="{{ route('dashboard') }}" class="group flex items-center gap-2 text-gray-600 hover:text-blue-600 transition-colors font-bold">
            <div class="bg-white p-2 rounded-xl shadow-sm group-hover:shadow-md transition-all text-xs">
                ⬅ Назад
            </div>
            В меню
        </a>
        <h2 class="text-2xl font-black uppercase tracking-tighter text-gray-800 text-center">Битва Роботов 🤖</h2>
        <div class="bg-white px-4 py-2 rounded-2xl shadow-sm border font-black text-blue-600">
            Уровень: <span id="level-display">1</span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <div class="bg-white/70 backdrop-blur-md rounded-[2rem] p-6 shadow-xl border border-white flex flex-col order-2 lg:order-1">
            <h3 class="text-sm font-black uppercase text-gray-400 mb-6 tracking-widest text-center">Алгоритм (5 шагов)</h3>
            
            <div id="command-slots" class="space-y-2 mb-6">
                @for($i=0; $i<5; $i++)
                <div class="command-slot h-12 bg-gray-100 rounded-xl border-2 border-dashed border-gray-200 flex items-center justify-center text-gray-300 font-bold uppercase text-[10px]">
                    Шаг {{ $i + 1 }}
                </div>
                @endfor
            </div>

            <div class="grid grid-cols-2 gap-2 mb-6">
                <button onclick="addCommand('forward', 'Вперед ⬆️')" class="bg-blue-600 hover:bg-blue-700 text-white p-3 rounded-xl font-black transition shadow-md active:scale-95 text-[10px] uppercase">Вперед</button>
                <button onclick="addCommand('fire', 'Выстрел 🔥')" class="bg-red-500 hover:bg-red-600 text-white p-3 rounded-xl font-black transition shadow-md active:scale-95 text-[10px] uppercase">Выстрел</button>
                <button onclick="addCommand('left', 'Влево ⬅️')" class="bg-slate-700 hover:bg-slate-800 text-white p-3 rounded-xl font-black transition shadow-md active:scale-95 text-[10px] uppercase">Влево</button>
                <button onclick="addCommand('right', 'Вправо ➡️')" class="bg-slate-700 hover:bg-slate-800 text-white p-3 rounded-xl font-black transition shadow-md active:scale-95 text-[10px] uppercase">Вправо</button>
            </div>

            <div class="flex gap-2">
                <button onclick="clearCommands()" class="flex-1 bg-gray-200 text-gray-600 p-4 rounded-xl font-black text-[10px] hover:bg-gray-300 transition uppercase">Сброс</button>
                <button onclick="runProgram()" id="run-btn" class="flex-[2] bg-green-500 hover:bg-green-600 text-white p-4 rounded-xl font-black text-[10px] shadow-lg shadow-green-100 transition uppercase tracking-widest">Запуск ▶️</button>
            </div>
        </div>

        <div class="lg:col-span-2 bg-slate-900 rounded-[2.5rem] p-4 md:p-8 shadow-2xl flex items-center justify-center min-h-[400px] order-1 lg:order-2">
            <div id="game-grid" class="relative grid grid-cols-5 grid-rows-5 gap-2 bg-slate-800/50 p-2 rounded-2xl border border-white/5">
                @for($i=0; $i<25; $i++)
                    <div class="grid-cell w-14 h-14 sm:w-16 sm:h-16 md:w-20 md:h-20 bg-slate-900/50 rounded-lg border border-white/5"></div>
                @endfor
                
                <div id="tank" class="absolute flex items-center justify-center text-4xl transition-all duration-500 z-20 pointer-events-none">
                    🚜
                </div>

                <div id="target" class="absolute flex items-center justify-center text-4xl z-10 pointer-events-none">
                    🎯
                </div>
                
                <div id="bullet" class="absolute w-4 h-4 bg-yellow-400 rounded-full hidden z-30 shadow-[0_0_15px_#facc15]"></div>
            </div>
        </div>
    </div>
</div>

<script>
    let program = [];
    const maxCommands = 5;
    let tankPos = { x: 0, y: 0, dir: 1 }; // 0:вверх, 1:вправо, 2:вниз, 3:влево
    let targetPos = { x: 4, y: 4 };
    let level = 1;

    function getCellData() {
        const firstCell = document.querySelector('.grid-cell');
        return {
            width: firstCell.offsetWidth,
            height: firstCell.offsetHeight,
            gap: 8 // gap-2 в Tailwind это 8px
        };
    }

    function updateObjectPos(id, coords, rotation = 0) {
        const cell = getCellData();
        const obj = document.getElementById(id);
        
        // Расчет позиции: отступ сетки (8px) + (размер клетки + отступ) * индекс
        const xPos = 8 + (cell.width + cell.gap) * coords.x;
        const yPos = 8 + (cell.height + cell.gap) * coords.y;
        
        obj.style.width = cell.width + 'px';
        obj.style.height = cell.height + 'px';
        obj.style.left = xPos + 'px';
        obj.style.top = yPos + 'px';
        
        if (id === 'tank') {
            obj.style.transform = `rotate(${(rotation - 1) * 90}deg)`; // -1 потому что эмодзи 🚜 смотрит вправо по дефолту
        }
    }

    function addCommand(type, label) {
        if (program.length >= maxCommands) return;
        program.push(type);
        const slots = document.querySelectorAll('.command-slot');
        const currentSlot = slots[program.length - 1];
        currentSlot.innerText = label;
        currentSlot.classList.remove('text-gray-300', 'border-dashed');
        currentSlot.classList.add('bg-blue-600', 'text-white', 'border-blue-400', 'shadow-sm');
    }

    function clearCommands() {
        program = [];
        document.querySelectorAll('.command-slot').forEach((slot, i) => {
            slot.innerText = `Шаг ${i + 1}`;
            slot.className = "command-slot h-12 bg-gray-100 rounded-xl border-2 border-dashed border-gray-200 flex items-center justify-center text-gray-300 font-bold uppercase text-[10px]";
        });
        resetTank();
    }

    function resetTank() {
        tankPos = { x: 0, y: 0, dir: 1 };
        updateObjectPos('tank', tankPos, tankPos.dir);
    }

    async function runProgram() {
        if (program.length === 0) return;
        const btn = document.getElementById('run-btn');
        btn.disabled = true;
        btn.opacity = "0.5";

        for (let cmd of program) {
            await executeCommand(cmd);
            await new Promise(r => setTimeout(r, 600));
        }

        checkWin();
        btn.disabled = false;
        btn.opacity = "1";
    }

    async function executeCommand(cmd) {
        if (cmd === 'forward') {
            if (tankPos.dir === 0 && tankPos.y > 0) tankPos.y--;
            else if (tankPos.dir === 1 && tankPos.x < 4) tankPos.x++;
            else if (tankPos.dir === 2 && tankPos.y < 4) tankPos.y++;
            else if (tankPos.dir === 3 && tankPos.x > 0) tankPos.x--;
        } else if (cmd === 'left') {
            tankPos.dir = (tankPos.dir + 3) % 4;
        } else if (cmd === 'right') {
            tankPos.dir = (tankPos.dir + 1) % 4;
        } else if (cmd === 'fire') {
            await showFire();
        }
        updateObjectPos('tank', tankPos, tankPos.dir);
    }

    async function showFire() {
        const bullet = document.getElementById('bullet');
        const cell = getCellData();
        const startX = 8 + (cell.width + cell.gap) * tankPos.x + (cell.width / 2) - 8;
        const startY = 8 + (cell.height + cell.gap) * tankPos.y + (cell.height / 2) - 8;
        
        bullet.style.left = startX + 'px';
        bullet.style.top = startY + 'px';
        bullet.classList.remove('hidden');

        let targetX = startX;
        let targetY = startY;

        if (tankPos.dir === 0) targetY -= 300;
        else if (tankPos.dir === 1) targetX += 300;
        else if (tankPos.dir === 2) targetY += 300;
        else if (tankPos.dir === 3) targetX -= 300;

        await new Promise(r => {
            bullet.style.transition = 'all 0.4s linear';
            setTimeout(() => {
                bullet.style.left = targetX + 'px';
                bullet.style.top = targetY + 'px';
                bullet.style.opacity = '0';
            }, 10);
            setTimeout(() => {
                bullet.classList.add('hidden');
                bullet.style.transition = 'none';
                bullet.style.opacity = '1';
                r();
            }, 400);
        });
    }

    function checkWin() {
        const isOnTarget = tankPos.x === targetPos.x && tankPos.y === targetPos.y;
        
        let hit = false;
        if (program.includes('fire')) {
             if (tankPos.dir === 1 && tankPos.y === targetPos.y && tankPos.x < targetPos.x) hit = true;
             if (tankPos.dir === 3 && tankPos.y === targetPos.y && tankPos.x > targetPos.x) hit = true;
             if (tankPos.dir === 0 && tankPos.x === targetPos.x && tankPos.y > targetPos.y) hit = true;
             if (tankPos.dir === 2 && tankPos.x === targetPos.x && tankPos.y < targetPos.y) hit = true;
        }

        if (isOnTarget || hit) {
            confetti({ particleCount: 150, spread: 70, origin: { y: 0.6 } });
            level++;
            document.getElementById('level-display').innerText = level;
            setTimeout(() => {
                alert("🎯 Точное попадание! Уровень пройден.");
                nextLevel();
            }, 500);
        } else {
            alert("❌ Промах! Попробуй составить другой алгоритм.");
            resetTank();
        }
    }

    function nextLevel() {
        // Генерируем новую цель, чтобы она не совпадала с танком
        do {
            targetPos = { 
                x: Math.floor(Math.random() * 5), 
                y: Math.floor(Math.random() * 5) 
            };
        } while (targetPos.x === 0 && targetPos.y === 0);
        
        updateObjectPos('target', targetPos);
        clearCommands();
    }

    window.addEventListener('resize', () => {
        updateObjectPos('tank', tankPos, tankPos.dir);
        updateObjectPos('target', targetPos);
    });

    document.addEventListener('DOMContentLoaded', () => {
        updateObjectPos('target', targetPos);
        resetTank();
    });
</script>

<style>
    #game-grid { touch-action: none; }
    #tank { transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); filter: drop-shadow(0 0 10px #3b82f6); }
    #target { animation: pulse 2s infinite; }
    @keyframes pulse { 0% { transform: scale(1); opacity: 1; } 50% { transform: scale(1.1); opacity: 0.7; } 100% { transform: scale(1); opacity: 1; } }
</style>
@endsection