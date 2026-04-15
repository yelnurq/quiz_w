@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    <div class="flex items-center justify-between">
        <a href="{{ route('admin.quizzes') }}" class="font-black text-gray-400 hover:text-blue-600 uppercase tracking-widest text-xs flex items-center gap-2">
            ← Назад к списку тестов
        </a>
        <span class="bg-blue-100 text-blue-600 px-4 py-1 rounded-full font-black text-[10px] uppercase tracking-widest">
            ID Теста: #{{ $quiz->id }}
        </span>
    </div>

    <div class="bg-gray-900 p-10 rounded-[3rem] text-white shadow-2xl">
        <h1 class="text-4xl font-black tracking-tighter italic">{{ $quiz->title }}</h1>
        <p class="opacity-60 font-medium mt-2">{{ $quiz->description }}</p>
    </div>

    <div class="bg-white/80 p-10 rounded-[3rem] shadow-xl border border-white">
        <h2 class="text-xl font-black mb-8 flex items-center gap-3">
            <span class="w-8 h-8 bg-yellow-400 rounded-lg flex items-center justify-center text-sm">❓</span>
            Добавить вопрос
        </h2>
        
        <form action="{{ url('/admin/quizzes/'.$quiz->id.'/questions/store') }}" method="POST" class="space-y-6">
            @csrf
            <textarea name="question_text" required placeholder="Напишите вопрос для 4-классника..." 
                      class="w-full px-8 py-5 rounded-3xl border-2 border-gray-100 focus:border-blue-500 outline-none font-bold text-lg"></textarea>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach(['a', 'b', 'c', 'd'] as $letter)
                <div class="relative">
                    <input type="text" name="option_{{ $letter }}" required placeholder="Вариант {{ strtoupper($letter) }}" 
                           class="w-full pl-14 pr-6 py-4 rounded-2xl border-2 border-gray-50 focus:border-green-400 outline-none font-bold">
                    <span class="absolute left-6 top-4 font-black text-gray-300 uppercase">{{ $letter }}</span>
                </div>
                @endforeach
            </div>

            <div class="bg-blue-50/50 p-6 rounded-3xl border border-blue-100 flex items-center justify-between">
                <span class="text-xs font-black uppercase text-blue-600 tracking-widest">Выберите правильный ответ:</span>
                <div class="flex gap-4">
                    @foreach(['a', 'b', 'c', 'd'] as $letter)
                    <label class="flex items-center gap-2 cursor-pointer group">
                        <input type="radio" name="correct_option" value="{{ $letter }}" required class="w-5 h-5">
                        <span class="font-black text-gray-700 group-hover:text-blue-600 uppercase">{{ $letter }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 text-white py-6 rounded-3xl font-black uppercase tracking-[0.2em] shadow-xl shadow-blue-100 hover:-translate-y-1 transition-all">
                Добавить в тест 🚀
            </button>
        </form>
    </div>

    <div class="space-y-4">
        <h3 class="text-lg font-black text-gray-900 ml-6 uppercase tracking-widest">Вопросы в этом тесте: {{ $questions->count() }}</h3>
        @foreach($questions as $q)
        <div class="bg-white/50 p-6 rounded-3xl border border-white flex justify-between items-center group transition-all">
            <p class="font-bold text-gray-700"><span class="text-blue-600 mr-2">#{{ $loop->iteration }}</span> {{ $q->question_text }}</p>
            <span class="px-4 py-1 bg-green-100 text-green-600 rounded-lg text-[10px] font-black uppercase tracking-widest">
                Ответ: {{ strtoupper($q->correct_option) }}
            </span>
        </div>
        @endforeach
    </div>
</div>
@endsection