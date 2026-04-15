@extends('layouts.app')

@section('title', 'Конструктор Тестов')

@section('content')
<div class="max-w-4xl mx-auto space-y-10">
    
    <div class="bg-white/80 backdrop-blur-xl p-10 rounded-[3rem] shadow-2xl border border-white">
        <div class="flex items-center gap-4 mb-8">
            <div class="bg-yellow-400 p-3 rounded-2xl shadow-lg shadow-yellow-100">
                <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
                </svg>
            </div>
            <h2 class="text-3xl font-black text-gray-900 tracking-tighter">Новый вопрос</h2>
        </div>

        <form action="{{ url('/admin/questions/store') }}" method="POST" class="space-y-6">
            @csrf
            <div>
                <label class="text-[10px] font-black uppercase tracking-[0.2em] text-gray-400 ml-4 mb-2 block">Текст вопроса (для детей)</label>
                <textarea name="text" rows="2" required placeholder="Например: Какое устройство называют «мышкой»?" 
                    class="w-full px-8 py-5 rounded-[2rem] border-2 border-gray-100 focus:border-blue-500 focus:ring-4 focus:ring-blue-500/10 outline-none transition-all font-bold text-lg text-gray-800"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="space-y-2">
                    <input type="text" name="option_a" required placeholder="Вариант А" class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 focus:border-green-400 outline-none font-bold italic">
                    <label class="flex items-center gap-2 ml-4">
                        <input type="radio" name="correct_answer" value="option_a" required class="w-4 h-4 text-blue-600">
                        <span class="text-xs font-black uppercase text-gray-400">Правильный</span>
                    </label>
                </div>
                <div class="space-y-2">
                    <input type="text" name="option_b" required placeholder="Вариант Б" class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 focus:border-green-400 outline-none font-bold italic">
                    <label class="flex items-center gap-2 ml-4">
                        <input type="radio" name="correct_answer" value="option_b" class="w-4 h-4 text-blue-600">
                        <span class="text-xs font-black uppercase text-gray-400">Правильный</span>
                    </label>
                </div>
                <div class="space-y-2">
                    <input type="text" name="option_c" required placeholder="Вариант В" class="w-full px-6 py-4 rounded-2xl border-2 border-gray-100 focus:border-green-400 outline-none font-bold italic">
                    <label class="flex items-center gap-2 ml-4">
                        <input type="radio" name="correct_answer" value="option_c" class="w-4 h-4 text-blue-600">
                        <span class="text-xs font-black uppercase text-gray-400">Правильный</span>
                    </label>
                </div>
            </div>

            <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white py-6 rounded-[2rem] font-black text-lg shadow-xl shadow-blue-200 transition-all hover:-translate-y-1 active:scale-95 uppercase tracking-widest">
                Сохранить в базу 🚀
            </button>
        </form>
    </div>

    <div class="space-y-4">
        <h3 class="text-xl font-black text-gray-900 ml-6 uppercase tracking-widest">База вопросов ({{ $questions->count() }})</h3>
        @foreach($questions as $q)
        <div class="bg-white/50 backdrop-blur-md p-6 rounded-3xl border border-white flex justify-between items-center group hover:bg-white transition-all">
            <div class="flex gap-4 items-center">
                <div class="w-10 h-10 rounded-xl bg-blue-50 flex items-center justify-center text-blue-600 font-black">
                    {{ $loop->iteration }}
                </div>
                <p class="font-bold text-gray-700">{{ $q->text }}</p>
            </div>
            <div class="flex gap-2">
                <span class="text-[10px] font-black uppercase bg-green-100 text-green-600 px-3 py-1 rounded-lg">
                    Верно: {{ strtoupper(str_replace('option_', '', $q->correct_answer)) }}
                </span>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection