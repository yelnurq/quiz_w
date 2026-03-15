@extends('layouts.app')

@section('title', 'Главная | IT-Знайка')

@section('content')
    <div class="mb-10 flex flex-col md:flex-row justify-between items-center bg-white/40 backdrop-blur-md p-8 rounded-3xl border border-white shadow-xl">
        <div class="text-center md:text-left">
            <h1 class="text-4xl font-black text-gray-900 leading-tight">
                Привет, {{ explode(' ', auth()->user()->name)[0] }}! 👋
            </h1>
            <p class="mt-2 text-lg text-gray-600 font-medium">Готов покорять мир технологий сегодня?</p>
        </div>
        
        @if(auth()->user()->role === 'admin')
            <div class="flex gap-3 mt-4 md:mt-0">
                <a href="{{ route('admin.quizzes') }}" class="bg-purple-600 hover:bg-purple-700 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-purple-200 transition-all hover:-translate-y-1 flex items-center gap-2">
                    <span>⚙️ Управление тестами</span>
                </a>
                <a href="{{ route('admin.users') }}" class="bg-yellow-600 hover:bg-purple-700 text-white px-6 py-3 rounded-2xl font-bold shadow-lg shadow-purple-200 transition-all hover:-translate-y-1 flex items-center gap-2">
                    <span>⚙️ Управление пользователями</span>
                </a>
            </div>
        @endif
    </div>
    <div class="w-full">
        <div class="flex justify-center mb-10">
            <div class="bg-white/50 backdrop-blur-sm p-2 rounded-[2rem] border border-white shadow-inner flex gap-2">
                <button type="button" 
                        id="btn-games"
                        onclick="switchTab('games')"
                        class="px-8 py-3 rounded-[1.5rem] font-black uppercase tracking-widest text-xs transition-all duration-300 bg-blue-600 text-white shadow-lg">
                    🎮 Мини-игры
                </button>
                <button type="button" 
                        id="btn-quizzes"
                        onclick="switchTab('quizzes')"
                        class="px-8 py-3 rounded-[1.5rem] font-black uppercase tracking-widest text-xs transition-all duration-300 text-gray-500 hover:bg-white">
                    📝 Тесты ({{ $quizzes->count() }})
                </button>
            </div>
        </div>

        <div id="content-games" class="tab-content transition-all duration-300">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <div class="group bg-white rounded-3xl shadow-sm border-2 border-transparent hover:border-blue-400 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 flex flex-col">
                    <div class="h-48 bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center relative overflow-hidden">
                        <span class="text-7xl group-hover:scale-110 transition-transform duration-500">🧩</span>
                        <div class="absolute bottom-4 left-4">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white text-xs font-black rounded-full uppercase tracking-widest text-[10px]">Твоя игра</span>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-2xl font-black text-gray-900 mb-2">IT-Ребус</h3>
                        <p class="text-gray-500 text-sm font-medium mb-6">Угадай секретные слова из мира компьютеров и стань настоящим знатоком!</p>
                        <div class="mt-auto">
                            <a href="{{ route('game1') }}" class="block text-center bg-blue-600 hover:bg-blue-700 text-white font-black py-4 rounded-2xl transition shadow-lg shadow-blue-100 uppercase tracking-wider text-sm">
                                Начать игру
                            </a>
                        </div>
                    </div>
                </div>

                <div class="group bg-white rounded-3xl shadow-sm border-2 border-transparent hover:border-yellow-500 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 flex flex-col">
                    <div class="h-48 bg-gradient-to-br from-yellow-400 to-amber-500 flex items-center justify-center relative overflow-hidden">
                        <span class="text-7xl group-hover:scale-110 transition-transform duration-500">⚡</span>
                        <div class="absolute bottom-4 left-4">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white text-xs font-black rounded-full uppercase tracking-widest text-[10px]">Логика</span>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-2xl font-black text-gray-900 mb-2">Скоростной Математик</h3>
                        <p class="text-gray-500 text-sm font-medium mb-6">Решай примеры быстрее, чем закончится время на таймере. Стань чемпионом!</p>
                        <div class="mt-auto">
                            <a href="{{ route('game5') }}" class="block text-center bg-yellow-500 hover:bg-yellow-600 text-white font-black py-4 rounded-2xl transition shadow-lg shadow-yellow-100 uppercase tracking-wider text-sm">
                                Начать отсчет
                            </a>
                        </div>
                    </div>
                </div>

                <div class="group bg-white rounded-3xl shadow-sm border-2 border-transparent hover:border-red-400 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 flex flex-col">
                    <div class="h-48 bg-gradient-to-br from-red-500 to-rose-600 flex items-center justify-center relative overflow-hidden">
                        <span class="text-7xl group-hover:scale-125 transition-transform duration-500">🛡️</span>
                        <div class="absolute bottom-4 left-4">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white text-xs font-black rounded-full uppercase tracking-widest text-[10px]">Безопасность</span>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-2xl font-black text-gray-900 mb-2">Кибер Патруль</h3>
                        <p class="text-gray-500 text-sm font-medium mb-6">Защити интернет от вирусов и хакеров. Стань героем цифровой безопасности!</p>
                        <div class="mt-auto">
                            <a href="{{ route('game3') }}" class="block text-center bg-red-600 hover:bg-red-700 text-white font-black py-4 rounded-2xl transition shadow-lg shadow-red-100 uppercase tracking-wider text-sm">
                                Начать патруль
                            </a>
                        </div>
                    </div>
                </div>

                <div class="group bg-white rounded-3xl shadow-sm border-2 border-transparent hover:border-indigo-400 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 flex flex-col">
                    <div class="h-48 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center relative overflow-hidden">
                        <span class="text-7xl group-hover:scale-110 transition-transform duration-500">🧠</span>
                        <div class="absolute bottom-4 left-4">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white text-xs font-black rounded-full uppercase tracking-widest text-[10px]">Логика</span>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-2xl font-black text-gray-900 mb-2">IT-Логика</h3>
                        <p class="text-gray-500 text-sm font-medium mb-6">Проверь свои знания! Успей определить, какое утверждение верное, а какое — нет.</p>
                        <div class="mt-auto">
                            <a href="{{ route('game6') }}" class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl transition shadow-lg shadow-indigo-100 uppercase tracking-wider text-sm">
                                Начать тест
                            </a>
                        </div>
                    </div>
                </div>

                <div class="group bg-white rounded-3xl shadow-sm border-2 border-transparent hover:border-indigo-400 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 flex flex-col">
                    <div class="h-48 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center relative overflow-hidden">
                        <span class="text-7xl group-hover:rotate-12 transition-transform duration-500">🚜</span>
                        <div class="absolute bottom-4 left-4">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white text-xs font-black rounded-full uppercase tracking-widest text-[10px]">Кодинг</span>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-2xl font-black text-gray-900 mb-2">Битва Танков</h3>
                        <p class="text-gray-500 text-sm font-medium mb-6">Программируй алгоритмы движений своего танка и поражай все цели на поле!</p>
                        <div class="mt-auto">
                            <a href="{{ route('game4') }}" class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl transition shadow-lg shadow-indigo-100 uppercase tracking-wider text-sm">
                                В бой!
                            </a>
                        </div>
                    </div>
                </div>

                <div class="group bg-white rounded-3xl shadow-sm border-2 border-transparent hover:border-purple-400 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 flex flex-col">
                    <div class="h-48 bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center relative overflow-hidden">
                        <span class="text-7xl group-hover:scale-110 transition-transform duration-500">🛠️</span>
                        <div class="absolute bottom-4 left-4">
                            <span class="px-3 py-1 bg-white/20 backdrop-blur-md text-white text-xs font-black rounded-full uppercase tracking-widest text-[10px]">Информатика</span>
                        </div>
                    </div>
                    <div class="p-6 flex-1 flex flex-col">
                        <h3 class="text-2xl font-black text-gray-900 mb-2">Мастер ПК</h3>
                        <p class="text-gray-500 text-sm font-medium mb-6">Собери свой мощный компьютер, правильно соединив все детали!</p>
                        <div class="mt-auto">
                            <a href="{{ route('game2') }}" class="block text-center bg-purple-600 hover:bg-purple-700 text-white font-black py-4 rounded-2xl transition shadow-lg shadow-purple-100 uppercase tracking-wider text-sm">
                                Собрать ПК
                            </a>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <div id="content-quizzes" class="tab-content hidden transition-all duration-300">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($quizzes as $quiz)
                    <div class="group bg-white rounded-[2.5rem] shadow-sm border-2 border-transparent hover:border-indigo-400 overflow-hidden transition-all duration-300 hover:shadow-2xl hover:-translate-y-2 flex flex-col">
                        <div class="h-40 bg-gradient-to-br from-indigo-500 to-purple-600 flex items-center justify-center relative">
                            <span class="text-6xl group-hover:rotate-12 transition-transform duration-500">📄</span>
                            <div class="absolute top-4 right-4 bg-white/20 backdrop-blur-md px-3 py-1 rounded-full text-white text-[10px] font-black uppercase">
                                Тест
                            </div>
                        </div>
                        <div class="p-8 flex-1 flex flex-col">
                            <h3 class="text-2xl font-black text-gray-900 mb-2">{{ $quiz->title }}</h3>
                            <p class="text-gray-500 text-sm font-medium mb-6 line-clamp-2 italic">
                                {{ $quiz->description ?? 'Проверь свои знания и получи высший балл!' }}
                            </p>
                            
                            <div class="mt-auto">
                                <a href="{{ route('tests.show', $quiz->id) }}" class="block text-center bg-indigo-600 hover:bg-indigo-700 text-white font-black py-4 rounded-2xl transition shadow-lg shadow-indigo-100 uppercase tracking-widest text-sm">
                                    Пройти тест
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full text-center py-20 bg-white/30 rounded-[3rem] border-4 border-dashed border-white">
                        <span class="text-6xl mb-4 block">📭</span>
                        <h3 class="text-2xl font-black text-gray-400 uppercase tracking-widest">Тестов пока нет</h3>
                        <p class="text-gray-500 font-medium mt-2 text-lg">Учитель еще не добавил новые испытания.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <script>
        function switchTab(tabName) {
            const btnGames = document.getElementById('btn-games');
            const btnQuizzes = document.getElementById('btn-quizzes');
            const contentGames = document.getElementById('content-games');
            const contentQuizzes = document.getElementById('content-quizzes');

            if (tabName === 'games') {
                // Стили кнопок
                btnGames.classList.add('bg-blue-600', 'text-white', 'shadow-lg');
                btnGames.classList.remove('text-gray-500', 'hover:bg-white');
                
                btnQuizzes.classList.remove('bg-indigo-600', 'text-white', 'shadow-lg');
                btnQuizzes.classList.add('text-gray-500', 'hover:bg-white');

                // Отображение контента
                contentGames.classList.remove('hidden');
                contentQuizzes.classList.add('hidden');
            } else {
                // Стили кнопок
                btnQuizzes.classList.add('bg-indigo-600', 'text-white', 'shadow-lg');
                btnQuizzes.classList.remove('text-gray-500', 'hover:bg-white');
                
                btnGames.classList.remove('bg-blue-600', 'text-white', 'shadow-lg');
                btnGames.classList.add('text-gray-500', 'hover:bg-white');

                // Отображение контента
                contentQuizzes.classList.remove('hidden');
                contentGames.classList.add('hidden');
            }
        }
    </script>

    <style>
        .hidden {
            display: none !important;
        }
        /* Анимация появления контента */
        .tab-content {
            animation: tabFadeIn 0.3s ease-out forwards;
        }
        @keyframes tabFadeIn {
            from { opacity: 0; transform: scale(0.98); }
            to { opacity: 1; transform: scale(1); }
        }
    </style>
@endsection