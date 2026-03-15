<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'IT-Знайка')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: #f0f4f8;
            overflow: hidden; /* Чтобы декоративные круги не создавали скролл */
        }

        .bubble {
            position: absolute;
            border-radius: 50%;
            filter: blur(60px);
            z-index: -1;
            animation: float 20s infinite alternate;
        }

        @keyframes float {
            0% { transform: translate(0, 0); }
            100% { transform: translate(50px, 100px); }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center p-4 relative">

    <div class="bubble bg-blue-200 w-96 h-96 -top-20 -left-20"></div>
    <div class="bubble bg-purple-200 w-80 h-80 bottom-0 -right-10" style="animation-duration: 25s;"></div>
    <div class="bubble bg-yellow-100 w-64 h-64 top-1/2 left-1/4" style="animation-delay: -5s;"></div>

    <div class="max-w-md w-full">
     
        <div class="bg-white/80 backdrop-blur-xl rounded-[2.5rem] shadow-2xl shadow-blue-900/10 border border-white p-10 relative overflow-hidden">
            
            <div class="absolute top-0 left-0 w-full h-1.5 bg-gray-100">
                <div id="global-progress" class="h-full bg-blue-500 transition-all duration-500" style="width: 0%"></div>
            </div>

            <div class="text-center mb-10">
                <div class="inline-block bg-blue-600 p-3 rounded-2xl shadow-lg shadow-blue-200 mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                    </svg>
                </div>
                <h1 class="text-4xl font-black text-gray-900 tracking-tight uppercase">IT-Знайка</h1>
                <p class="text-blue-600 font-black text-[10px] uppercase tracking-[0.2em] mt-2">@yield('subtitle', 'Мир технологий')</p>
            </div>

            <div class="space-y-6">
                @yield('content')
            </div>
        </div>

        <p class="text-center mt-8 text-gray-400 text-xs font-medium uppercase tracking-widest">
            &copy; {{ date('Y') }} Школа программирования
        </p>
    </div>

</body>
</html>