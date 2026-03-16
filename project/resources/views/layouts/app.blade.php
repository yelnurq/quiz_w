<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'DevQuiz')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Анимированный фоновый градиент */
        body {
            background: linear-gradient(-45deg, #f3f4f6, #e5e7eb, #dbeafe, #f3f4f6);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Декоративные круги на фоне */
        .bg-circle {
            position: fixed;
            z-index: -1;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
        }
    </style>
</head>
<body class="min-h-screen flex flex-col">

    <div class="bg-circle bg-blue-200 w-96 h-96 -top-20 -left-20"></div>
    <div class="bg-circle bg-purple-200 w-80 h-80 top-1/2 -right-20"></div>
    <div class="bg-circle bg-yellow-100 w-64 h-64 bottom-10 left-1/4"></div>

    <nav class="bg-white/80 backdrop-blur-md shadow-sm border-b sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16 items-center">
                <div class="flex items-center">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-2 group">
                        <div class="bg-blue-600 p-1.5 rounded-lg group-hover:rotate-12 transition-transform">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>
                        <span class="text-xl font-black text-gray-800 tracking-tight">IT-Знайка</span>
                    </a>
                </div>
                
                @auth
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-gray-900 leading-tight">{{ auth()->user()->name }}</p>
                        <p class="text-[10px] text-blue-600 font-black uppercase tracking-widest">
                            {{ auth()->user()->role === 'admin' ? 'Учитель' : 'Ученик 4 Класса' }}
                        </p>
                    </div>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="group flex items-center gap-2 bg-red-50 hover:bg-red-500 text-red-600 hover:text-white px-4 py-2 rounded-xl text-sm font-bold transition-all border border-red-100">
                            <span>Выйти</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" /></svg>
                        </button>
                    </form>
                </div>
                @endauth
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10 flex-grow w-full">
        @yield('content')
    </main>

    <footer class="mt-auto py-8 border-t bg-white/50 backdrop-blur-sm">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center gap-4 text-gray-500 text-sm">
                <p>&copy; {{ date('Y') }} <strong>IT-Знайка</strong>. Твой проводник в мир цифр.</p>
                <div class="flex gap-6">
                    <span class="hover:text-blue-600 cursor-help">Помощь</span>
                    <span class="hover:text-blue-600 cursor-help">Правила</span>
                </div>
            </div>
        </div>
    </footer>

</body>
</html>