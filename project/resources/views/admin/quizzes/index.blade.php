@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto space-y-10">
    <div class="bg-white/80 backdrop-blur-xl p-8 rounded-[2.5rem] border border-white shadow-2xl">
        <h2 class="text-3xl font-black text-gray-900 mb-6 italic tracking-tighter">🆕 Создать новый тест</h2>
        <form action="{{ url('/admin/quizzes/store') }}" method="POST" class="space-y-4">
            @csrf
            <div class="flex flex-col md:flex-row gap-4">
                <input type="text" name="title" placeholder="Название (напр. Основы сетей)" required 
                       class="flex-grow px-8 py-5 rounded-2xl border-2 border-gray-100 focus:border-blue-500 outline-none font-bold text-lg">
                <button type="submit" class="bg-blue-600 text-white px-10 py-5 rounded-2xl font-black uppercase tracking-widest hover:bg-blue-700 transition-all shadow-lg shadow-blue-100">
                    Создать Тест
                </button>
            </div>
            <textarea name="description" placeholder="Краткое описание для детей..." class="w-full px-8 py-4 rounded-2xl border-2 border-gray-100 focus:border-blue-500 outline-none font-medium"></textarea>
        </form>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($quizzes as $quiz)
        <div class="group bg-white/60 backdrop-blur-md p-8 rounded-[2.5rem] border border-white shadow-lg hover:shadow-2xl transition-all flex flex-col justify-between">
            <div>
                <div class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center text-2xl mb-4 group-hover:rotate-12 transition-transform">📚</div>
                <h3 class="text-2xl font-black text-gray-900 leading-tight mb-2">{{ $quiz->title }}</h3>
                <p class="text-gray-500 text-sm font-medium mb-6 line-clamp-2 italic">{{ $quiz->description }}</p>
            </div>
            <a href="{{ route('admin.quizzes.questions', $quiz->id) }}" 
               class="inline-block w-full text-center py-4 bg-gray-900 text-white rounded-2xl font-black uppercase tracking-widest text-xs hover:bg-blue-600 transition-colors">
                Наполнить вопросами →
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection