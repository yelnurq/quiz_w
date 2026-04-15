<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\User;


Route::middleware('guest')->group(function () {
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});


use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

// 1. Главная страница админки: Список всех квизов и форма создания
Route::get('/admin/quizzes', function () {
    $quizzes = DB::table('quizzes')->latest()->get();
    return view('admin.quizzes.index', compact('quizzes'));
})->name('admin.quizzes');

// 2. Создание квиза (папки для вопросов)
Route::post('/admin/quizzes/store', function (Request $request) {
    DB::table('quizzes')->insert([
        'title' => $request->title,
        'description' => $request->description,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    return back();
});

// 3. Управление вопросами конкретного квиза
Route::get('/admin/quizzes/{id}/questions', function ($id) {
    $quiz = DB::table('quizzes')->where('id', $id)->first();
    $questions = DB::table('questions')->where('quiz_id', $id)->get();
    return view('admin.quizzes.questions', compact('quiz', 'questions'));
})->name('admin.quizzes.questions');

// 4. Сохранение вопроса в конкретный квиз
Route::post('/admin/quizzes/{id}/questions/store', function (Request $request, $id) {
    DB::table('questions')->insert([
        'quiz_id' => $id,
        'question_text' => $request->question_text,
        'option_a' => $request->option_a,
        'option_b' => $request->option_b,
        'option_c' => $request->option_c,
        'option_d' => $request->option_d,
        'correct_option' => $request->correct_option,
        'created_at' => now(),
        'updated_at' => now(),
    ]);
    return back();
});

Route::get('/admin/users', function () {
    // Проверка: пускаем только админов
    if (auth()->guest() || auth()->user()->role !== 'admin') {
        abort(403, 'Доступ только для администраторов');
    }

    // Получаем всех пользователей из базы
    $users = User::latest()->get();

    return view('admin.users', compact('users'));
})->name('admin.users')->middleware('auth');


// Страница прохождения теста для ученика
Route::get('/tests/{id}', function ($id) {
    // Получаем тест
    $quiz = DB::table('quizzes')->where('id', $id)->first();
    
    if (!$quiz) {
        abort(404);
    }

    // Получаем вопросы к этому тесту
    $questions = DB::table('questions')->where('quiz_id', $id)->get();

    return view('tests.show', compact('quiz', 'questions'));
})->name('tests.show');

// Обработка результатов теста (куда отправляются ответы)
Route::post('/tests/{id}/submit', function (Request $request, $id) {
    $questions = DB::table('questions')->where('quiz_id', $id)->get();
    $score = 0;
    $total = $questions->count();

    foreach ($questions as $question) {
        $inputName = 'question_' . $question->id;
        if ($request->$inputName === $question->correct_option) {
            $score++;
        }
    }

    // Здесь можно сохранить результат в базу данных, если есть таблица результатов
    // А пока просто вернем на страницу с результатом
    return back()->with('test_result', "Ты ответил правильно на $score из $total вопросов!");
})->name('tests.submit');

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/', function () {
    $quizzes = DB::table('quizzes')->get(); // Получаем твои созданные тесты
    return view('dashboard', compact('quizzes'));
})->name('dashboard');
});

Route::get('/game2', function () {
    return view('games/game2');
})->middleware(['auth'])->name('game2');

Route::get('/game1', function () {
    return view('games/game1');
})->middleware(['auth'])->name('game1');


Route::get('/game3', function () {
    return view('games/game3');
})->middleware(['auth'])->name('game3');

Route::get('/game4', function () {
    return view('games/game4');
})->middleware(['auth'])->name('game4');

Route::get('/game5', function () {
    return view('games/game5');
})->middleware(['auth'])->name('game5');

Route::get('/game6', function () {
    return view('games/game6');
})->middleware(['auth'])->name('game6');