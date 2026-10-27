@extends('layouts.app')
@section('content')
    <div class="mb-7 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <div
                class="mb-2 inline-flex items-center gap-2 rounded-full bg-blue-50 px-3 py-1 text-xs font-bold text-blue-700">
                <span class="h-2 w-2 rounded-full bg-blue-500"></span> CAMPUS OVERVIEW
            </div>
            <h1 class="heading text-2xl font-extrabold tracking-tight text-slate-900 md:text-3xl">Good day, Administrator
            </h1>
            <p class="mt-2 text-sm text-slate-500">Here’s what’s happening across your school facilities.</p>
        </div><a href="{{ route('buildings.create') }}" class="btn btn-primary">＋ Add building</a>
    </div>
    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">@foreach($stats as $stat)<a href="{{ $stat['href'] }}"
        class="card group p-5 transition hover:-translate-y-0.5 hover:shadow-md">
        <div class="flex items-start justify-between">
            <div>
                <p class="text-sm font-semibold text-slate-500">{{ $stat['label'] }}</p>
                <p class="heading mt-3 text-3xl font-extrabold text-slate-900">{{ number_format($stat['value']) }}</p>
                <p class="mt-2 text-xs font-semibold text-blue-700">View records <span
                        class="transition group-hover:translate-x-1">→</span></p>
            </div>
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-2xl text-blue-700">
                {{ $stat['icon'] }}
            </div>
        </div>
    </a>@endforeach</div>
    <div class="mt-7 grid grid-cols-1 gap-5 xl:grid-cols-3">
        <section class="card overflow-hidden xl:col-span-2">
            <div class="flex items-center justify-between border-b border-slate-100 px-5 py-5 md:px-6">
                <div>
                    <h2 class="heading font-extrabold text-slate-900">Campus buildings</h2>
                    <p class="mt-1 text-xs text-slate-500">Recently added facilities</p>
                </div><a href="{{ route('buildings.index') }}" class="text-sm font-bold text-blue-700">View all →</a>
            </div>
            <div class="table-wrap">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Building</th>
                            <th>Address</th>
                            <th>Floors</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>@forelse($recentBuildings as $building)
                        <tr>
                            <td class="font-bold text-slate-800">{{ $building->name }}</td>
                            <td class="text-slate-500">{{ $building->address }}</td>
                            <td><span
                                    class="rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-700">{{ $building->floors_count }}</span>
                            </td>
                            <td><a href="{{ route('buildings.edit', $building) }}" class="font-bold text-blue-700">Edit</a>
                            </td>
                    </tr>@empty<tr>
                            <td colspan="4" class="py-10 text-center text-slate-500">No buildings yet. Add your first campus
                                building.</td>
                        </tr>@endforelse
                    </tbody>
                </table>
            </div>
        </section>
        <section class="card p-5 md:p-6">
            <h2 class="heading font-extrabold text-slate-900">Quick actions</h2>
            <p class="mt-1 text-xs text-slate-500">Jump into common tasks</p>
            <div class="mt-5 space-y-3">
                @foreach([['Add a building', 'Set up a campus location', 'buildings.create', '▦'], ['Add a floor', 'Organize a building level', 'floors.create', '▤'], ['Add a classroom', 'Register a room', 'rooms.create', '▣'], ['Add a teacher', 'Create a staff profile', 'teachers.create', '♙']] as $action)<a
                    href="{{ route($action[2]) }}"
                    class="flex items-center gap-3 rounded-xl border border-slate-100 p-3 transition hover:border-blue-200 hover:bg-blue-50/50">
                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-lg text-slate-700">
                        {{ $action[3] }}
                    </div>
                    <div class="min-w-0 flex-1">
                        <p class="text-sm font-bold text-slate-800">{{ $action[0] }}</p>
                        <p class="mt-0.5 text-xs text-slate-500">{{ $action[1] }}</p>
                    </div><span class="text-slate-400">→</span>
                </a>@endforeach
            </div>
        </section>
    </div>
    <div class="card mt-5 p-5 md:p-6">
        <div class="mb-4 flex items-center justify-between">
            <div>
                <h2 class="heading font-extrabold text-slate-900">Recently added teachers</h2>
                <p class="mt-1 text-xs text-slate-500">Latest staff profiles in your directory</p>
            </div><a href="{{ route('teachers.index') }}" class="text-sm font-bold text-blue-700">Manage teachers →</a>
        </div>
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4">@forelse($recentTeachers as $teacher)
            <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-3">@if($teacher->image)<img
                src="{{ asset('storage/' . $teacher->image) }}" class="h-11 w-11 rounded-full object-cover"
            alt="{{ $teacher->name }}">@else<div
                        class="flex h-11 w-11 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-800">
                        {{ strtoupper(substr($teacher->name, 0, 1)) }}
                    </div>@endif<div class="min-w-0">
                    <p class="truncate text-sm font-bold text-slate-800">{{ $teacher->name }}</p>
                    <p class="truncate text-xs text-slate-500">{{ $teacher->subject ?: 'Subject not set' }}</p>
                </div>
        </div>@empty<p class="text-sm text-slate-500">No teacher profiles yet.</p>@endforelse
        </div>
    </div>
@endsection