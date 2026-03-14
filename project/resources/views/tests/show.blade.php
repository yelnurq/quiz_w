@extends('layouts.app')

@section('title', $quiz->title . ' | IT-Знайка')

@section('content')
<div class="max-w-4xl mx-auto space-y-8">
    
    <div class="bg-white/40 backdrop-blur-md p-8 rounded-[2.5rem] border border-white shadow-xl">
        <div class="flex flex-col md:flex-row justify-between items-center gap-4">
            <div>
                <h1 class="text-3xl font-black text-gray-900 italic tracking-tighter">{{ $quiz->title }}</h1>
                <p class="text-gray-500 font-bold uppercase text-[10px] tracking-[0.2em] mt-1">
                    Вопрос <span id="current-step-text">1</span> из <span>{{ $questions->count() }}</span>
                </p>
            </div>
            <div class="w-full md:w-64 h-4 bg-gray-200/50 rounded-full overflow-hidden p-1 shadow-inner">
                <div id="progress-bar" 
                     class="h-full bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full transition-all duration-500" 
                     style="width: {{ (1 / $questions->count()) * 100 }}%"></div>
            </div>
        </div>
    </div>

    @if(session('test_result'))
  <div class="bg-gradient-to-br from-indigo-600 to-purple-700 p-10 rounded-[2.5rem] text-center text-white shadow-2xl animate-fade-in">
            <span class="text-6xl mb-4 block">📊</span>
            <h2 class="text-3xl font-black mb-3">Тест завершен!</h2>
            <div class="bg-white/20 backdrop-blur-lg rounded-2xl p-5 inline-block mb-6">
                <p class="text-xl font-bold">Твой результат:</p>
                <p class="text-4xl font-black mt-1">{{ session('test_result') }}</p>
            </div>
            <div class="flex justify-center gap-4">
                <a href="{{ route('dashboard') }}" class="bg-white text-indigo-600 px-6 py-3 rounded-xl font-black uppercase tracking-widest text-sm hover:scale-105 transition-transform shadow-xl">На главную</a>
            </div>
        </div>
    @else
        <form action="{{ route('tests.submit', $quiz->id) }}" method="POST" id="quiz-form">
            @csrf
            
            @foreach($questions as $index => $q)
            <div id="step-{{ $index + 1 }}" class="quiz-step {{ $index === 0 ? '' : 'hidden' }}">
                <div class="bg-white rounded-[3rem] p-10 shadow-2xl border-b-8 border-indigo-100">
                    <h2 class="text-2xl font-black text-gray-800 mb-10 leading-snug">
                        {{ $q->question_text }}
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach(['a', 'b', 'c', 'd'] as $letter)
                            @php $optionField = 'option_' . $letter; @endphp
                            @if(!empty($q->$optionField))
                            <label class="relative group cursor-pointer">
                                <input type="radio" name="question_{{ $q->id }}" value="{{ $letter }}" class="peer hidden" {{ $index === 0 ? 'required' : '' }}>
                                <div class="p-6 rounded-3xl border-2 border-gray-100 bg-gray-50/50 text-lg font-bold text-gray-700 transition-all 
                                            peer-checked:bg-indigo-600 peer-checked:text-white peer-checked:border-indigo-600 peer-checked:scale-[1.02]
                                            group-hover:border-indigo-300">
                                    <span class="inline-block w-8 h-8 rounded-lg bg-white/20 text-center leading-8 mr-3 uppercase text-sm font-black">{{ $letter }}</span>
                                    {{ $q->$optionField }}
                                </div>
                            </label>
                            @endif
                        @endforeach
                    </div>
                </div>

                <div class="mt-8 flex justify-between items-center px-4">
                    @if($index > 0)
                        <button type="button" onclick="changeStep({{ $index + 1 }}, {{ $index }})" 
                                class="bg-white text-gray-400 px-8 py-4 rounded-2xl font-black uppercase tracking-widest hover:text-gray-900 transition-colors">
                            ← Назад
                        </button>
                    @else
                        <div></div> @endif

                    @if($index + 1 < $questions->count())
                        <button type="button" onclick="changeStep({{ $index + 1 }}, {{ $index + 2 }})" 
                                class="bg-indigo-600 text-white px-10 py-5 rounded-2xl font-black uppercase tracking-[0.2em] shadow-lg shadow-indigo-100 hover:bg-indigo-700 transition-all active:scale-95">
                            Дальше 🚀
                        </button>
                    @else
                        <button type="submit" 
                                class="bg-green-500 text-white px-10 py-5 rounded-2xl font-black uppercase tracking-[0.2em] shadow-lg shadow-green-100 hover:bg-green-600 transition-all animate-pulse">
                            Завершить 🏁
                        </button>
                    @endif
                </div>
            </div>
            @endforeach
        </form>
    @endif
</div>

<script>
    const totalSteps = {{ $questions->count() }};

    function changeStep(current, next) {
        if (next > current) {
            const currentInputs = document.querySelectorAll(`#step-${current} input[type="radio"]`);
            let answered = false;
            currentInputs.forEach(input => { if(input.checked) answered = true; });
            
            if (!answered) {
                alert('Пожалуйста, выбери вариант ответа!');
                return;
            }
        }

        document.getElementById(`step-${current}`).classList.add('hidden');
        document.getElementById(`step-${next}`).classList.remove('hidden');

        document.getElementById('current-step-text').innerText = next;
        const progress = (next / totalSteps) * 100;
        document.getElementById('progress-bar').style.width = progress + '%';
        
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }
</script>

<style>
    .hidden { display: none !important; }
    
    .quiz-step {
        animation: slideIn 0.4s ease-out forwards;
    }

    @keyframes slideIn {
        from { opacity: 0; transform: translateX(20px); }
        to { opacity: 1; transform: translateX(0); }
    }

    .animate-fade-in {
        animation: fadeIn 0.6s ease-out;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(20px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection