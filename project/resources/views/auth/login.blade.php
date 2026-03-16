<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Вход | Викторина</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-8">С возвращением!</h2>

        @if($errors->has('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded mb-4 text-sm">
                {{ $errors->first('error') }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required
                    class="w-full px-4 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Пароль</label>
                <input type="password" name="password" required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                    <span class="ml-2 text-sm text-gray-600">Запомнить меня</span>
                </label>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-lg transition duration-200 shadow-md">
                Войти
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            Впервые здесь? <a href="{{ route('register') }}" class="text-blue-600 hover:underline font-medium">Создать аккаунт</a>
        </p>
    </div>

</body>
</html>