<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\Question;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Тест на русском: Основы IT
        $quizRu = Quiz::create([
            'title' => 'Основы компьютерной грамотности',
            'description' => 'Проверь свои базовые знания об устройстве компьютера и ПО.',
        ]);

        $questionsRu = [
            [
                'question_text' => 'Что является "мозгом" компьютера?',
                'option_a' => 'Монитор', 'option_b' => 'Процессор', 'option_c' => 'Клавиатура', 'option_d' => 'Мышь',
                'correct_option' => 'b'
            ],
            [
                'question_text' => 'Какое устройство используется для хранения данных?',
                'option_a' => 'Жесткий диск', 'option_b' => 'Блок питания', 'option_c' => 'Принтер', 'option_d' => 'Колонки',
                'correct_option' => 'a'
            ],
            [
                'question_text' => 'Какая клавиша обычно используется для отмены действия?',
                'option_a' => 'Enter', 'option_b' => 'Shift', 'option_c' => 'Esc', 'option_d' => 'Space',
                'correct_option' => 'c'
            ],
            [
                'question_text' => 'Что из этого является операционной системой?',
                'option_a' => 'Google Chrome', 'option_b' => 'Microsoft Word', 'option_c' => 'Windows 11', 'option_d' => 'Photoshop',
                'correct_option' => 'c'
            ],
            [
                'question_text' => 'Для чего нужна комбинация Ctrl + C?',
                'option_a' => 'Вставить', 'option_b' => 'Копировать', 'option_c' => 'Вырезать', 'option_d' => 'Удалить',
                'correct_option' => 'b'
            ],
            [
                'question_text' => 'Какое устройство выводит изображение?',
                'option_a' => 'Микрофон', 'option_b' => 'Сканер', 'option_c' => 'Монитор', 'option_d' => 'Процессор',
                'correct_option' => 'c'
            ],
            [
                'question_text' => 'Как называется главная плата в компьютере?',
                'option_a' => 'Материнская плата', 'option_b' => 'Звуковая карта', 'option_c' => 'Видеокарта', 'option_d' => 'Сетевая карта',
                'correct_option' => 'a'
            ],
            [
                'question_text' => '1 гигабайт — это сколько мегабайт (примерно)?',
                'option_a' => '100', 'option_b' => '512', 'option_c' => '1024', 'option_d' => '2048',
                'correct_option' => 'c'
            ],
            [
                'question_text' => 'Что такое браузер?',
                'option_a' => 'Программа для печати', 'option_b' => 'Антивирус', 'option_c' => 'Программа для интернета', 'option_d' => 'Игра',
                'correct_option' => 'c'
            ],
            [
                'question_text' => 'Безопасное извлечение флешки нужно для...',
                'option_a' => 'Экономии энергии', 'option_b' => 'Чтобы не стерлись данные', 'option_c' => 'Красоты', 'option_d' => 'Чтобы флешка не остыла',
                'correct_option' => 'b'
            ],
        ];

        foreach ($questionsRu as $q) {
            $quizRu->questions()->create($q);
        }

        // 2. Тест на казахском: Интернет қауіпсіздігі
        $quizKz = Quiz::create([
            'title' => 'Интернет қауіпсіздігі',
            'description' => 'Желідегі қауіпсіздік ережелерін қаншалықты білесің?',
        ]);

        $questionsKz = [
            [
                'question_text' => 'Күрделі құпия сөз қандай болуы керек?',
                'option_a' => 'Тек сандар', 'option_b' => 'Туған күнің', 'option_c' => 'Әріптер, сандар және белгілер', 'option_d' => 'Есімің',
                'correct_option' => 'c'
            ],
            [
                'question_text' => 'Компьютерді вирустардан не қорғайды?',
                'option_a' => 'Браузер', 'option_b' => 'Антивирус', 'option_c' => 'Желі', 'option_d' => 'Экран',
                'correct_option' => 'b'
            ],
            [
                'question_text' => 'Бөтен адамға құпия сөзді айтуға бола ма?',
                'option_a' => 'Иә', 'option_b' => 'Тек досыма', 'option_c' => 'Жоқ, ешқашан', 'option_d' => 'Керек болса',
                'correct_option' => 'c'
            ],
            [
                'question_text' => 'Интернеттегі алаяқтық қалай аталады?',
                'option_a' => 'Самминг', 'option_b' => 'Фишинг', 'option_c' => 'Боулинг', 'option_d' => 'Тренинг',
                'correct_option' => 'b'
            ],
            [
                'question_text' => 'Бейтаныс адамнан келген сілтемені ашуға бола ма?',
                'option_a' => 'Болады', 'option_b' => 'Тек қызық болса', 'option_c' => 'Жоқ, қауіпті', 'option_d' => 'Иә, егер сурет болса',
                'correct_option' => 'c'
            ],
            [
                'question_text' => 'Әлеуметтік желіде парақшаңды қалай қорғауға болады?',
                'option_a' => 'Екі факторлы аутентификациямен', 'option_b' => 'Сурет қоймау', 'option_c' => 'Ешкімге жазбау', 'option_d' => 'Дос қоспау',
                'correct_option' => 'a'
            ],
            [
                'question_text' => 'Спам деген не?',
                'option_a' => 'Пайдалы хат', 'option_b' => 'Керексіз жарнамалық хаттар', 'option_c' => 'Досыңның хаты', 'option_d' => 'Жаңалықтар',
                'correct_option' => 'b'
            ],
            [
                'question_text' => 'Интернетте біреу сені ренжітсе не істеу керек?',
                'option_a' => 'Жауап қайтару', 'option_b' => 'Үндемеу', 'option_c' => 'Үлкендерге айту және блоктау', 'option_d' => 'Жылау',
                'correct_option' => 'c'
            ],
            [
                'question_text' => 'Wi-Fi желісіне құпия сөз қою керек пе?',
                'option_a' => 'Міндетті түрде', 'option_b' => 'Керек емес', 'option_c' => 'Тек көршілер үшін', 'option_d' => 'Білмеймін',
                'correct_option' => 'a'
            ],
            [
                'question_text' => 'Интернетте жеке мәліметтерді (мекенжай, тел) жариялауға бола ма?',
                'option_a' => 'Иә', 'option_b' => 'Жоқ, бұл қауіпсіз емес', 'option_c' => 'Тек топтарда', 'option_d' => 'Қаласам',
                'correct_option' => 'b'
            ],
        ];

        foreach ($questionsKz as $q) {
            $quizKz->questions()->create($q);
        }
    }
}