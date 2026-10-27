<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? 'Dashboard' }} · CampusFlow</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@500;600;700;800&display=swap"
        rel="stylesheet">@vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            font-family: 'DM Sans', sans-serif;
            background: #f6f8fb;
            color: #172033
        }

        .heading {
            font-family: Manrope, sans-serif
        }

        .nav-link {
            display: flex;
            align-items: center;
            gap: .75rem;
            border-radius: 12px;
            padding: .7rem .85rem;
            color: #aebbd0;
            font-size: .92rem;
            font-weight: 600;
            transition: .18s
        }

        .nav-link:hover,
        .nav-link.active {
            background: #253750;
            color: white
        }

        .nav-link.active {
            box-shadow: inset 3px 0 #73a7ff
        }

        .field {
            width: 100%;
            border: 1px solid #dce3ed;
            border-radius: 10px;
            padding: .75rem .85rem;
            background: white;
            outline: none
        }

        .field:focus {
            border-color: #5387d9;
            box-shadow: 0 0 0 3px #5387d91a
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: .5rem;
            border-radius: 10px;
            padding: .7rem 1rem;
            font-size: .9rem;
            font-weight: 700;
            transition: .15s
        }

        .btn-primary {
            background: #2457a7;
            color: white
        }

        .btn-primary:hover {
            background: #194582
        }

        .btn-light {
            background: #eef2f7;
            color: #34435a
        }

        .card {
            background: white;
            border: 1px solid #e8edf4;
            border-radius: 18px;
            box-shadow: 0 3px 14px #233b5b06
        }

        .table-wrap {
            overflow-x: auto
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            min-width: 600px
        }

        .data-table th {
            text-align: left;
            color: #718096;
            font-size: .72rem;
            text-transform: uppercase;
            letter-spacing: .08em;
            font-weight: 700;
            background: #f8fafc;
            padding: 14px 20px
        }

        .data-table td {
            padding: 15px 20px;
            border-top: 1px solid #edf1f6;
            font-size: .9rem
        }

        .data-table tr:hover td {
            background: #fbfcfe
        }

        .muted {
            color: #78869a
        }

        .mobile-nav {
            display: none
        }

        @media(max-width:767px) {
            .desktop-sidebar {
                display: none
            }

            .mobile-nav {
                display: block
            }

            .data-table {
                min-width: 540px
            }

            .page-pad {
                padding: 1rem
            }

            .mobile-hide {
                display: none !important
            }
        }
    </style>
</head>

<body>
    <div class="min-h-screen md:flex">
        <aside class="desktop-sidebar fixed inset-y-0 left-0 z-30 flex w-64 flex-col bg-[#17263c] px-4 py-6 text-white">
            <a href="{{ route('dashboard') }}" class="mb-9 flex items-center gap-3 px-2">
                <div class="flex h-11 w-11 items-center justify-center rounded-2xl bg-blue-500 text-xl font-extrabold">C
                </div>
                <div>
                    <div class="heading text-lg font-extrabold tracking-tight">CampusFlow</div>
                    <div class="text-xs text-slate-400">School administration</div>
                </div>
            </a>
            <div class="px-3 pb-2 text-[10px] font-bold uppercase tracking-[.2em] text-slate-500">Workspace</div>
            <nav class="space-y-1"><a class="nav-link {{ request()->routeIs('dashboard') ? 'active' : '' }}"
                    href="{{ route('dashboard') }}"><span>◫</span> Overview</a><a
                    class="nav-link {{ request()->routeIs('buildings.*') ? 'active' : '' }}"
                    href="{{ route('buildings.index') }}"><span>▦</span> Buildings</a><a
                    class="nav-link {{ request()->routeIs('floors.*') ? 'active' : '' }}"
                    href="{{ route('floors.index') }}"><span>▤</span> Floors</a><a
                    class="nav-link {{ request()->routeIs('rooms.*') ? 'active' : '' }}"
                    href="{{ route('rooms.index') }}"><span>▣</span> Classrooms</a><a
                    class="nav-link {{ request()->routeIs('teachers.*', 'teacher.*') ? 'active' : '' }}"
                    href="{{ route('teacher.index') }}"><span>♙</span> Teachers</a></nav>
            <div class="mt-auto rounded-2xl border border-white/10 bg-white/5 p-4">
                <div class="mb-2 text-xs font-bold text-slate-300">CAMPUS OVERVIEW</div>
                <p class="text-xs leading-5 text-slate-400">Keep your campus spaces and staff organized in one place.
                </p>
            </div>
        </aside>
        <main class="min-w-0 flex-1 md:ml-64">
            <header
                class="sticky top-0 z-20 flex h-[72px] items-center justify-between border-b border-slate-200/80 bg-white/90 px-4 backdrop-blur md:px-8">
                <div>
                        <div class="heading text-sm font-bold text-slate-800 md:text-base">School Management</div>
                        <div class="hidden text-xs text-slate-500 sm:block">Campus operations workspace</div>
                </div>
                <div class="flex items-center gap-3"><span class="hidden text-right sm:block"><span
                            class="block text-sm font-bold text-slate-700">Administrator</span><span
                            class="block text-xs text-slate-500">Workspace</span></span>
                    <div
                        class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 font-bold text-blue-800">
                        AD</div>
                </div>
            </header>
            <div id="mobileMenu" class="mobile-nav hidden border-b border-slate-200 bg-white px-4 py-3">
                <nav class="grid grid-cols-2 gap-2"><a class="rounded-lg bg-slate-100 px-3 py-2 text-sm font-semibold"
                        href="{{ route('dashboard') }}">Overview</a><a
                        class="rounded-lg bg-slate-100 px-3 py-2 text-sm font-semibold"
                        href="{{ route('buildings.index') }}">Buildings</a><a
                        class="rounded-lg bg-slate-100 px-3 py-2 text-sm font-semibold"
                        href="{{ route('floors.index') }}">Floors</a><a
                        class="rounded-lg bg-slate-100 px-3 py-2 text-sm font-semibold"
                        href="{{ route('rooms.index') }}">Classrooms</a><a
                        class="rounded-lg bg-slate-100 px-3 py-2 text-sm font-semibold"
                        href="{{ route('teacher.index') }}">Teachers</a></nav>
            </div>
            <div class="page-pad mx-auto max-w-[1500px] p-4 md:p-8">@if(session('success'))
                <div
                    class="mb-5 flex items-center gap-3 rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm font-semibold text-emerald-800">
            <span>✓</span>{{ session('success') }}</div>@endif @if(session('error'))
                        <div
                            class="mb-5 rounded-xl border border-rose-200 bg-rose-50 px-4 py-3 text-sm font-semibold text-rose-800">
                    {{ session('error') }}</div>@endif @yield('content')
                <footer
                    class="mt-10 flex flex-col justify-between gap-2 border-t border-slate-200 pt-5 text-xs text-slate-500 sm:flex-row">
                    <span>© {{ date('Y') }} CampusFlow · School Management</span><span>Built for organized campus
                        operations</span></footer>
            </div>
        </main>
    </div>
    <div id="ajax-notice"
        class="fixed right-4 top-4 z-50 hidden max-w-sm rounded-xl border px-4 py-3 text-sm font-semibold shadow-lg">
    </div>
    <script>
        const csrf = document.querySelector('meta[name="csrf-token"]').content;
        const notice = (message, error = false) => { const el = document.getElementById('ajax-notice'); el.textContent = message; el.className = `fixed right-4 top-4 z-50 max-w-sm rounded-xl border px-4 py-3 text-sm font-semibold shadow-lg ${error ? 'border-rose-200 bg-rose-50 text-rose-700' : 'border-emerald-200 bg-emerald-50 text-emerald-700'}`; setTimeout(() => el.classList.add('hidden'), 3500) };
        const bindImagePreview = () => { const input = document.querySelector('[data-image-preview]'), preview = document.getElementById('teacher-avatar-preview'); if (input && preview) input.onchange = () => { const file = input.files[0]; if (file) { const image = document.createElement('img'); image.src = URL.createObjectURL(file); image.className = 'h-full w-full object-cover'; image.alt = 'Profile preview'; preview.replaceChildren(image) } } };
        const loadResults = async (url, replace = true) => { const response = await fetch(url, { headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' } }); if (!response.ok) throw new Error('Unable to load records.'); const data = await response.json(); const target = document.getElementById('records-results'); if (target) target.innerHTML = data.html; if (replace) history.pushState({}, '', url) };
        document.addEventListener('submit', async event => { const form = event.target; if (form.matches('.record-search')) { event.preventDefault(); const url = `${form.action}?${new URLSearchParams(new FormData(form)).toString()}`; try { await loadResults(url); notice('Search updated.') } catch (error) { notice(error.message, true) } return } if (form.matches('[data-confirm]') && !confirm(form.dataset.confirm || 'Are you sure you want to delete this record?')) { event.preventDefault(); return } if (!form.matches('[data-ajax-form]')) return; event.preventDefault(); const button = form.querySelector('button[type="submit"]'); if (button) button.disabled = true; try { const response = await fetch(form.action, { method: form.method || 'POST', body: new FormData(form), headers: { Accept: 'application/json', 'X-Requested-With': 'XMLHttpRequest' } }); const data = await response.json(); if (!response.ok) { form.querySelectorAll('[data-ajax-error]').forEach(error => error.remove()); Object.entries(data.errors || {}).forEach(([field, messages]) => { const input = form.querySelector(`[name="${field}"]`); if (input) { const error = document.createElement('p'); error.dataset.ajaxError = ''; error.className = 'mt-1.5 text-xs font-semibold text-rose-600'; error.textContent = messages[0]; input.closest('div').append(error) } }); throw new Error(Object.values(data.errors || {}).flat()[0] || data.message || 'Please check the form.') } notice(data.message || 'Saved successfully.'); if (data.redirect) { const page = await fetch(data.redirect, { headers: { Accept: 'text/html' } }); const html = await page.text(); const parsed = new DOMParser().parseFromString(html, 'text/html'); document.querySelector('main').replaceWith(parsed.querySelector('main')); history.pushState({}, '', data.redirect); bindImagePreview() } else if (form.closest('#records-results')) await loadResults(window.location.href, false) } catch (error) { notice(error.message, true) } finally { if (button) button.disabled = false } });
        document.addEventListener('click', async event => { const link = event.target.closest('#records-results a'); if (!link || link.closest('.record-search') || link.dataset.confirm) return; if (link.closest('.pagination')) { event.preventDefault(); try { await loadResults(link.href); notice('Page loaded.') } catch (error) { notice(error.message, true) } } });
        bindImagePreview();
    </script>
</body>

</html>