@extends('layouts.app')
@section('content')
    <div class="mb-6"><a href="{{ route($type . '.index') }}" class="text-sm font-bold text-blue-700">← Back to
            {{ $type === 'rooms' ? 'classrooms' : $type }}</a>
        <div class="mt-4 text-xs font-bold uppercase tracking-[.15em] text-blue-700">Directory / {{ $title }}</div>
        <h1 class="heading mt-2 text-2xl font-extrabold tracking-tight text-slate-900 md:text-3xl">{{ $title }}</h1>
        <p class="mt-2 text-sm text-slate-500">Enter the details below. Fields marked required must be completed.</p>
    </div>
    <div class="card max-w-3xl p-5 md:p-8">
        <form method="POST" action="{{ $record->exists ? route($type . '.update', $record) : route($type . '.store') }}"
            enctype="multipart/form-data" data-ajax-form>@csrf @if($record->exists) @method('PUT') @endif
            @if($type === 'teachers')
                <div class="mb-7 flex items-center gap-4 rounded-2xl bg-slate-50 p-4">
                    <div id="teacher-avatar-preview"
                        class="flex h-16 w-16 shrink-0 items-center justify-center overflow-hidden rounded-2xl bg-blue-100 text-xl font-extrabold text-blue-800">
                        @if($record->image)<img src="{{ asset('storage/' . $record->image) }}" class="h-full w-full object-cover"
                        alt="">@else{{ strtoupper(substr($record->name ?: 'T', 0, 1)) }}@endif</div>
                    <div>
                        <p class="font-bold text-slate-800">
                            {{ $record->exists ? 'Update teacher profile' : 'Create teacher profile' }}</p>
                        <p class="mt-1 text-sm text-slate-500">Add a clear name, subject, and optional profile photo.</p>
                    </div>
            </div>@endif
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">@foreach($fields as $field)
                <div class="{{ in_array($field['name'], ['address']) ? 'sm:col-span-2' : '' }}"><label
                        class="mb-2 block text-sm font-bold text-slate-700" for="{{ $field['name'] }}">{{ $field['label'] }}
                        @if($field['required'])<span class="text-rose-500">*</span>@endif</label>
                    @if(isset($field['options']))<select class="field" id="{{ $field['name'] }}" name="{{ $field['name'] }}"
                            {{ $field['required'] ? 'required' : '' }}>
                            <option value="">Select {{ strtolower($field['label']) }}</option>
                            @foreach($field['options'] as $value => $label)
                                <option value="{{ $value }}"
                                    @selected(old($field['name'], $field['selected'] ?? $record->{$field['name']} ?? '') == $value)>
                            {{ $label }}</option>@endforeach
                        </select>
                    @elseif(($field['type'] ?? 'text') === 'file')<input class="field" id="{{ $field['name'] }}" type="file"
                        name="{{ $field['name'] }}" accept="image/png,image/jpeg,image/webp"
                        data-image-preview>@if($record->image)
                            <p class="mt-2 text-xs text-slate-500">Current photo: <a class="font-bold text-blue-700" target="_blank"
                        href="{{ asset('storage/' . $record->image) }}">View image</a></p>@endif
                    @else<input class="field" id="{{ $field['name'] }}" type="{{ $field['type'] ?? 'text' }}"
                        name="{{ $field['name'] }}" value="{{ old($field['name'], $record->{$field['name']} ?? '') }}" {{ $field['required'] ? 'required' : '' }} @if(($field['type'] ?? '') === 'number') min="18" max="100" @endif
                    placeholder="Enter {{ strtolower($field['label']) }}">@endif
                    @error($field['name'])
                    <p class="mt-1.5 text-xs font-semibold text-rose-600">{{ $message }}</p>@enderror
            </div>@endforeach
            </div>
            <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end"><a
                    href="{{ route($type . '.index') }}" class="btn btn-light">Cancel</a><button class="btn btn-primary"
                    type="submit">{{ $record->exists ? 'Save changes' : 'Create record' }} <span>→</span></button></div>
        </form>
    </div>
    <div class="mt-5 flex items-start gap-3 rounded-xl border border-blue-100 bg-blue-50 p-4 text-sm text-blue-900"><span
            class="text-lg">ⓘ</span>
        <p><strong>Helpful tip</strong><br><span class="text-blue-800">Use clear, consistent names so campus records are
                easy to search and maintain.</span></p>
    </div>
@endsection