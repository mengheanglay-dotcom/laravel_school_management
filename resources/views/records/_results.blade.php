<div class="card overflow-hidden">
    <div
        class="flex flex-col gap-3 border-b border-slate-100 p-4 md:flex-row md:items-center md:justify-between md:px-5">
        <div>
            <p class="font-bold text-slate-800">All {{ strtolower($title) }}</p>
            <p class="mt-1 text-xs text-slate-500" id="record-count">{{ $records->total() }} record(s) found</p>
        </div>
        <form method="GET" action="{{ route($type . '.index') }}"
            class="record-search flex w-full flex-col gap-2 sm:flex-row md:w-auto">
            <input class="field min-w-0 sm:w-64" name="search" value="{{ request('search') }}"
                placeholder="Search {{ strtolower($title) }}…" aria-label="Search records">
            @if($type === 'teachers' && isset($subjects))
                <select class="field sm:w-44" name="subject">
                    <option value="">All subjects</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject }}" @selected(request('subject') === $subject)>{{ $subject }}</option>
                    @endforeach
                </select>
            @endif
            <button class="btn btn-light" type="submit">Search</button>
            @if(request()->hasAny(['search', 'subject']))
                <a class="btn btn-light" href="{{ route($type . '.index') }}">Reset</a>
            @endif
        </form>
    </div>
    <div class="table-wrap">
        <table class="data-table">
            <thead>
                <tr>
                    @if($type === 'buildings')
                        <th>Building</th>
                        <th>Address</th>
                        <th>Floors</th>
                        <th>Added</th>
                    @elseif($type === 'floors')
                        <th>Floor</th>
                        <th>Building</th>
                        <th>Classrooms</th>
                        <th>Added</th>
                    @elseif($type === 'rooms')
                        <th>Classroom</th>
                        <th>Floor</th>
                        <th>Building</th>
                        <th>Added</th>
                    @else<th>Teacher</th>
                        <th>Subject</th>
                        <th>Age</th>
                    <th>Added</th>@endif
                    <th class="text-right">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $record)
                    <tr>
                        @if($type === 'buildings')
                            <td>
                                <div class="font-bold text-slate-800">{{ $record->name }}</div>
                                <div class="mt-1 text-xs text-slate-400">ID #{{ $record->id }}</div>
                            </td>
                            <td>{{ $record->address }}</td>
                            <td><span
                                    class="rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-700">{{ $record->floors_count ?? 0 }}
                                    floors</span></td>
                            <td class="text-slate-500">{{ $record->created_at->format('M d, Y') }}</td>
                        @elseif($type === 'floors')
                            <td class="font-bold text-slate-800">Floor {{ $record->floor_number }}</td>
                            <td>{{ $record->building?->name ?? '—' }}</td>
                            <td><span
                                    class="rounded-lg bg-blue-50 px-2.5 py-1 text-xs font-bold text-blue-700">{{ $record->rooms_count ?? 0 }}
                                    rooms</span></td>
                            <td class="text-slate-500">{{ $record->created_at->format('M d, Y') }}</td>
                        @elseif($type === 'rooms')
                            <td class="font-bold text-slate-800">Room {{ $record->room_number }}</td>
                            <td>{{ $record->floor?->floor_number ?? '—' }}</td>
                            <td>{{ $record->floor?->building?->name ?? '—' }}</td>
                            <td class="text-slate-500">{{ $record->created_at->format('M d, Y') }}</td>
                        @else
                            <td>
                                <div class="flex items-center gap-3">@if($record->image)<img
                                    src="{{ asset('storage/' . $record->image) }}"
                                class="h-10 w-10 rounded-full object-cover" alt="">@else<div
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-800">
                                            {{ strtoupper(substr($record->name, 0, 1)) }}
                                        </div>@endif<div>
                                        <div class="font-bold text-slate-800">{{ $record->name }}</div>
                                        <div class="mt-1 text-xs text-slate-400">Staff ID #{{ $record->id }}</div>
                                    </div>
                                </div>
                            </td>
                            <td><span
                                    class="rounded-lg bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-700">{{ $record->subject ?: 'Not assigned' }}</span>
                            </td>
                            <td>{{ $record->age ? $record->age . ' years' : '—' }}</td>
                            <td class="text-slate-500">{{ $record->created_at->format('M d, Y') }}</td>
                        @endif
                        <td>
                            <div class="flex items-center justify-end gap-2"><a href="{{ route($type . '.edit', $record) }}"
                                    class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-bold text-slate-700 hover:border-blue-300 hover:text-blue-700">Edit</a>
                                <form method="POST" action="{{ route($type . '.destroy', $record) }}"
                                    data-confirm="Delete this record? This action cannot be undone." data-ajax-form>@csrf
                                    @method('DELETE')<button
                                        class="rounded-lg border border-rose-100 px-3 py-2 text-xs font-bold text-rose-600 hover:bg-rose-50"
                                        type="submit">Delete</button></form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-16 text-center">
                            <div
                                class="mx-auto mb-3 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-2xl text-slate-500">
                                ⌕</div>
                            <p class="font-bold text-slate-800">No records found</p>
                            <p class="mt-1 text-sm text-slate-500">Try another search or add your first record.</p><a
                                href="{{ route($type . '.create') }}" class="btn btn-primary mt-4">＋ Add record</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($records->hasPages())
    <div class="border-t border-slate-100 px-5 py-4">{{ $records->links() }}</div>@endif
</div>