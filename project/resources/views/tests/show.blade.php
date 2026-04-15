@extends('layouts.app')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8">
        <h1 class="text-4xl font-black text-gray-900 tracking-tighter">{{ $quiz->title }}</h1>
        <p class="text-blue-600 font-bold uppercase tracking-widest text-xs mt-2">Всего вопросов: {{ $quiz->questions->count() }}</p>
    </div>

    <form action="{{ route('tests.submit', $quiz->id) }}" method="POST" class="space-y-6">
        @csrf
        @foreach($quiz->questions as $index => $q)
        <div class="bg-white/70 backdrop-blur-md p-8 rounded-[2.5rem] border border-white shadow-xl">
            <div class="flex items-start gap-4 mb-6">
                <span class="bg-blue-600 text-white w-8 h-8 rounded-lg flex items-center justify-center font-black shrink-0">
                    {{ $index + 1 }}
                </span>
                <h3 class="text-xl font-bold text-gray-800 leading-tight pt-1">{{ $q->question_text }}</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @foreach(['a', 'b', 'c', 'd'] as $letter)
                <label class="group relative cursor-pointer">
                    <input type="radio" name="answers[{{ $q->id }}]" value="{{ $letter }}" class="peer hidden" required>
                    <div class="p-4 rounded-2xl border-2 border-gray-100 bg-gray-50/50 transition-all 
                                peer-checked:border-blue-500 peer-checked:bg-blue-50 group-hover:border-blue-200">
                        <span class="font-black text-blue-500 mr-2 uppercase">{{ $letter }}.</span>
                        <span class="font-medium text-gray-700">{{ $q->{'option_' . $letter} }}</span>
                    </div>
                </label>
                @endforeach
            </div>
        </div>
        @endforeach

        <div class="flex justify-center pt-10">
            <button type="submit" class="bg-gray-900 hover:bg-blue-600 text-white px-16 py-5 rounded-2xl font-black transition-all shadow-xl hover:-translate-y-1 uppercase tracking-widest">
                Завершить тест
            </button>
        </div>
    </form>
</div>
@endsection