<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Регистрация | Викторина</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

    <div class="max-w-md w-full bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 text-center mb-8">Создать аккаунт</h2>

        <form action="{{ route('register') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Ваше имя</label>
                <input type="text" name="name" value="{{ old('name') }}" 
                    class="w-full px-4 py-2 border @error('name') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Электронная почта</label>
                <input type="email" name="email" value="{{ old('email') }}" 
                    class="w-full px-4 py-2 border @error('email') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Кто вы?</label>
                <select name="role" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none bg-white transition">
                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Студент</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Администратор</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Пароль</label>
                <input type="password" name="password" 
                    class="w-full px-4 py-2 border @error('password') border-red-500 @else border-gray-300 @enderror rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
                @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Подтвердите пароль</label>
                <input type="password" name="password_confirmation" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:outline-none transition">
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-2.5 rounded-lg transition duration-200 shadow-md">
                Зарегистрироваться
            </button>
        </form>

        <p class="text-center text-sm text-gray-600 mt-6">
            Уже есть аккаунт? <a href="{{ route('login') }}" class="text-blue-600 hover:underline font-medium">Войти</a>
        </p>
    </div>

</body>
</html>