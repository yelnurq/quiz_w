@extends('layouts.app')

@section('title', 'Управление пользователями | IT-Знайка')

@section('content')
<div class="space-y-6">
    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 bg-white/40 backdrop-blur-md p-6 rounded-3xl border border-white/20 shadow-xl">
        <div>
            <h1 class="text-3xl font-black text-gray-900 tracking-tight">Панель управления</h1>
            <p class="text-gray-500 font-medium">Всего зарегистрировано: {{ $users->count() }} пользователей</p>
        </div>
        <div class="flex gap-2">
            <span class="px-4 py-2 bg-blue-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-blue-200">
                Студенты: {{ $users->where('role', 'student')->count() }}
            </span>
            <span class="px-4 py-2 bg-purple-600 text-white rounded-xl text-sm font-bold shadow-lg shadow-purple-200">
                Админы: {{ $users->where('role', 'admin')->count() }}
            </span>
        </div>
    </div>

    <div class="bg-white/70 backdrop-blur-md rounded-3xl border border-white/20 shadow-2xl overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-50/50">
                        <th class="px-6 py-4 text-xs font-black uppercase text-gray-400 tracking-widest">ID</th>
                        <th class="px-6 py-4 text-xs font-black uppercase text-gray-400 tracking-widest">Пользователь</th>
                        <th class="px-6 py-4 text-xs font-black uppercase text-gray-400 tracking-widest">Email</th>
                        <th class="px-6 py-4 text-xs font-black uppercase text-gray-400 tracking-widest">Роль</th>
                        <th class="px-6 py-4 text-xs font-black uppercase text-gray-400 tracking-widest">Дата регистрации</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($users as $user)
                    <tr class="hover:bg-blue-50/30 transition-colors group">
                        <td class="px-6 py-4 text-sm font-bold text-gray-400">#{{ $user->id }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white font-black shadow-md">
                                    {{ mb_substr($user->name, 0, 1) }}
                                </div>
                                <span class="font-bold text-gray-800">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600 font-medium">{{ $user->email }}</td>
                        <td class="px-6 py-4">
                            @if($user->role === 'admin')
                                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-lg text-xs font-black uppercase">Admin</span>
                            @else
                                <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg text-xs font-black uppercase">Student</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-500 italic">
                            {{ $user->created_at->format('d.m.Y') }}
                        </td>
                        
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection