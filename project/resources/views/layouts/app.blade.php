<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'IT-Знайка')</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700;900&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
    
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background: linear-gradient(-45deg, #f3f4f6, #e5e7eb, #dbeafe, #f3f4f6);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }

        @keyframes gradient {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        .bg-circle {
            position: fixed;
            z-index: -1;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0.4;
        }
        
        /* Стили для сертификата */
        #cert-wrap {
            font-family: 'Montserrat', sans-serif;
            color: #1f2937;
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
                    <a href="/" class="flex items-center gap-3 group">
                        <div class="bg-blue-600 p-2 rounded-xl group-hover:rotate-12 transition-all duration-300 shadow-lg shadow-blue-200">
                            <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z" />
                            </svg>
                        </div>

                        <div class="flex flex-col justify-center">
                            <span class="text-2xl font-black text-gray-900 tracking-tighter leading-none">
                                IT-Знайка
                            </span>
                            <div class="flex items-center gap-2 mt-1">
                                <span class="h-px w-4 bg-blue-400"></span>
                                <span class="text-[10px] uppercase font-bold text-blue-600 tracking-widest leading-none">
                                    Преподаватель: Ерсултанова А.С.
                                </span>
                            </div>
                        </div>
                    </a>
                </div>
                
                @auth
                <div class="flex items-center space-x-4">
                    <div class="text-right hidden sm:block">
                        <p class="text-sm font-bold text-gray-900 leading-tight">{{ auth()->user()->name }}</p>
                    </div>
                    
                    <button onclick="downloadCertificate()" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-bold transition-all flex items-center gap-2 shadow-lg shadow-blue-100">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
                        Сертификат
                    </button>

                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="group flex items-center gap-2 bg-red-50 hover:bg-red-500 text-red-600 hover:text-white px-4 py-2 rounded-xl text-sm font-bold transition-all border border-red-100">
                            <span>Выйти</span>
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

    <div style="position: absolute; left: -9999px; top: -9999px;">
        <div id="certificate-template" style="width: 1000px; height: 700px; background: white; padding: 60px; position: relative; border: 20px solid #2563eb; font-family: 'Montserrat', sans-serif;">
            <div style="position: absolute; top: 0; left: 0; width: 200px; height: 200px; background: #eff6ff; clip-path: polygon(0 0, 100% 0, 0 100%); z-index: 1;"></div>
            
            <div id="cert-wrap" style="position: relative; z-index: 10; text-align: center;">
                <h1 style="font-size: 64px; color: #1e40af; margin-bottom: 10px; font-weight: 900; text-transform: uppercase; letter-spacing: -1px;">Сертификат</h1>
                <p style="font-size: 22px; color: #6b7280; margin-bottom: 50px; font-weight: 400;">подтверждает успешное завершение обучения</p>
                
                <p style="font-size: 18px; color: #374151; text-transform: uppercase; tracking-widest">Настоящий документ выдан:</p>
                <div style="font-size: 52px; font-weight: 900; color: #111827; margin: 15px 0; padding-bottom: 5px; border-bottom: 4px solid #2563eb; display: inline-block; min-width: 600px; letter-spacing: -1px;">
                    {{ auth()->check() ? auth()->user()->name : 'Имя Пользователя' }}
                </div>
                
                <p style="font-size: 22px; color: #4b5563; max-width: 750px; margin: 40px auto 0; line-height: 1.5; font-weight: 400;">
                    За выдающиеся успехи и освоение ключевых компетенций в рамках образовательной программы платформы <strong>«IT-Знайка»</strong>.
                </p>

                <div style="margin-top: 100px; display: flex; justify-content: space-between; align-items: flex-end; padding: 0 40px;">
                    <div style="text-align: left;">
                        <p style="font-size: 12px; color: #9ca3af; text-transform: uppercase; font-weight: bold; margin-bottom: 5px;">Дата выдачи</p>
                        <p style="font-size: 18px; color: #1f2937; font-weight: 700;">{{ date('d.m.Y') }}</p>
                    </div>
                    
                    <div style="text-align: center;">
                        <div style="border: 2px solid #2563eb; color: #2563eb; padding: 8px 24px; border-radius: 50px; font-weight: 900; text-transform: uppercase; font-size: 14px; letter-spacing: 1px;">
                            IT-Знайка 2026
                        </div>
                    </div>

                    <div style="text-align: right;">
                        <p style="font-size: 14px; color: #9ca3af; font-weight: bold; text-transform: uppercase; margin: 0;">Преподаватель</p>
                        <p style="font-size: 18px; font-weight: 900; color: #1e40af; margin: 0;">Ерсултанова А.С.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        async function downloadCertificate() {
            const { jsPDF } = window.jspdf;
            const element = document.getElementById('certificate-template');
            const btn = event.currentTarget;
            const originalText = btn.innerHTML;
            
            btn.innerHTML = '<span class="animate-pulse">Генерация...</span>';
            btn.disabled = true;

            try {
                const canvas = await html2canvas(element, {
                    scale: 3, // Еще выше качество для печати
                    logging: false,
                    useCORS: true,
                    backgroundColor: "#ffffff"
                });
                
                const imgData = canvas.toDataURL('image/png');
                const pdf = new jsPDF('l', 'px', [canvas.width, canvas.height]);
                
                pdf.addImage(imgData, 'PNG', 0, 0, pdf.internal.pageSize.getWidth(), pdf.internal.pageSize.getHeight());
                pdf.save(`Сертификат_IT_Знайка_${new Date().toLocaleDateString()}.pdf`);
            } catch (error) {
                console.error(error);
                alert("Ошибка при создании PDF");
            } finally {
                btn.innerHTML = originalText;
                btn.disabled = false;
            }
        }
    </script>
</body>
</html>