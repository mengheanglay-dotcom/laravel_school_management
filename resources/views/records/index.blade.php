@extends('layouts.app')
@section('content')
    <div class="mb-6 flex flex-col justify-between gap-4 sm:flex-row sm:items-end">
        <div>
            <div class="mb-2 text-xs font-bold uppercase tracking-[.15em] text-blue-700">Directory / {{ $title }}</div>
            <h1 class="heading text-2xl font-extrabold tracking-tight text-slate-900 md:text-3xl">{{ $title }}</h1>
            <p class="mt-2 text-sm text-slate-500">{{ $subtitle }}</p>
        </div><a href="{{ route($type . '.create') }}" class="btn btn-primary">＋ Add
            {{ $type === 'rooms' ? 'classroom' : rtrim($type, 's') }}</a>
    </div>
    <div id="records-results">@include('records._results')</div>
    @if($errors->any())
        <div class="mt-4 rounded-xl border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">Please check the form errors.
    </div>@endif
@endsection