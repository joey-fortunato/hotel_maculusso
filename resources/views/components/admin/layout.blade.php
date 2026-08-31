@props(['title' => 'Painel', 'subtitle' => null])
@php
    $newReservations = \App\Models\Reservation::where('status', 'pending')->count();
    $unreadMessages = \App\Models\Message::where('is_read', false)->count();

    $groups = [
        'Operação' => [
            ['label' => 'Painel', 'route' => 'admin.dashboard', 'pattern' => 'admin.dashboard', 'icon' => 'M4 13h6V4H4zM14 20h6v-9h-6zM14 8h6V4h-6zM4 20h6v-4H4z'],
            ['label' => 'Reservas', 'route' => 'admin.reservations.index', 'pattern' => 'admin.reservations.*', 'icon' => 'M7 3v3M17 3v3M4 8h16M5 5h14a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1z', 'badge' => $newReservations],
            ['label' => 'Mensagens', 'route' => 'admin.messages.index', 'pattern' => 'admin.messages.*', 'icon' => 'M4 5h16v12H8l-4 3z', 'badge' => $unreadMessages],
            ['label' => 'Manutenção', 'route' => 'admin.maintenance.edit', 'pattern' => 'admin.maintenance.*', 'icon' => 'M10.3 4.3a4 4 0 0 0 5.4 5.4l3.8 3.8a2 2 0 0 1-2.8 2.8l-3.8-3.8a4 4 0 0 1-5.4-5.4l2 2 1.6-1.6z'],
        ],
        'Conteúdo' => [
            ['label' => 'Páginas', 'route' => 'admin.pages.edit', 'pattern' => 'admin.pages.*', 'icon' => 'M6 3h9l3 3v15H6zM15 3v4h4'],
            ['label' => 'Quartos', 'route' => 'admin.rooms.index', 'pattern' => 'admin.rooms.*', 'icon' => 'M3 10V7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v3M3 10h18M3 10v8m18-8v8M3 14h18M7 10V8h4v2'],
            ['label' => 'Serviços', 'route' => 'admin.services.index', 'pattern' => 'admin.services.*', 'icon' => 'M12 3a9 9 0 1 0 0 18 9 9 0 0 0 0-18zM12 8v8M8 12h8'],
            ['label' => 'Comodidades', 'route' => 'admin.amenities.index', 'pattern' => 'admin.amenities.*', 'icon' => 'M5 13l4 4L19 7'],
            ['label' => 'Testemunhos', 'route' => 'admin.testimonials.index', 'pattern' => 'admin.testimonials.*', 'icon' => 'M8 10h.01M12 10h.01M16 10h.01M5 4h14a1 1 0 0 1 1 1v10a1 1 0 0 1-1 1H9l-4 4V5a1 1 0 0 1 1-1z'],
            ['label' => 'Restaurante', 'route' => 'admin.restaurant-items.index', 'pattern' => 'admin.restaurant-items.*', 'icon' => 'M5 3v8a2 2 0 0 0 4 0V3M7 11v10M16 3c-1.5 0-2.5 2-2.5 4.5S14.5 12 16 12v9'],
            ['label' => 'Galeria', 'route' => 'admin.gallery.index', 'pattern' => 'admin.gallery.*', 'icon' => 'M4 5h16v14H4zM4 15l4-4 4 4 3-3 5 5'],
        ],
    ];

    // Super-admin-only section.
    if (auth()->user()->is_super_admin) {
        $groups['Administração'] = [
            ['label' => 'Auditoria', 'route' => 'admin.audit.index', 'pattern' => 'admin.audit.*', 'icon' => 'M9 12l2 2 4-4M7.8 4.6a2 2 0 0 1 1.4-.6h5.6a2 2 0 0 1 1.4.6l2.2 2.2a2 2 0 0 1 .6 1.4v9.8a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V8.2a2 2 0 0 1 .6-1.4z'],
        ];
    }
@endphp
<!doctype html>
<html lang="pt" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} · Maculusso CMS</title>
    <link rel="icon" href="{{ asset('images/brand/maculusso-logo.png') }}" type="image/png">
    <style>[x-cloak]{display:none!important}</style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body x-data="{ sidebar: false }" class="cms min-h-screen bg-sand-100 text-espresso-900 antialiased">
    <div class="flex min-h-screen">
        {{-- Sidebar --}}
        <aside class="fixed inset-y-0 left-0 z-40 flex w-64 -translate-x-full flex-col bg-espresso-900 text-sand-200 transition-transform lg:static lg:translate-x-0"
               :class="sidebar ? 'translate-x-0' : ''">
            <div class="flex h-16 shrink-0 items-center gap-3 border-b border-white/10 px-6">
                <img src="{{ asset('images/brand/maculusso-logo.png') }}" alt="Maculusso" class="h-8 w-auto logo-invert">
                <span class="border-l border-white/15 pl-3 text-[10px] font-semibold uppercase tracking-[.22em] text-sand-200/45">Gestão</span>
            </div>
            <nav class="flex flex-1 flex-col overflow-y-auto px-3 pb-4">
                @foreach($groups as $groupLabel => $items)
                    <p class="cms-nav-group">{{ $groupLabel }}</p>
                    @foreach($items as $item)
                        <a href="{{ route($item['route']) }}" class="cms-nav-link" @if(request()->routeIs($item['pattern'])) data-active @endif>
                            <svg class="h-[18px] w-[18px] shrink-0" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $item['icon'] }}"/></svg>
                            <span class="flex-1">{{ $item['label'] }}</span>
                            @if(!empty($item['badge']) && $item['badge'] > 0)
                                <span class="grid h-5 min-w-5 place-items-center rounded-full bg-copper-500 px-1.5 text-[11px] font-bold text-white">{{ $item['badge'] }}</span>
                            @endif
                        </a>
                    @endforeach
                @endforeach
            </nav>
            <div class="shrink-0 border-t border-white/10 p-3">
                <a href="{{ route('home', 'pt') }}" target="_blank" class="flex items-center gap-3 px-4 py-2.5 text-xs font-medium uppercase tracking-[.14em] text-sand-200/50 transition hover:text-copper-400">
                    <svg class="h-[18px] w-[18px]" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M14 5h5v5M19 5l-8 8M11 5H6a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-5"/></svg>
                    Ver o site
                </a>
            </div>
        </aside>

        {{-- Backdrop (mobile) --}}
        <div x-show="sidebar" x-cloak x-transition.opacity @click="sidebar = false" class="fixed inset-0 z-30 bg-espresso-900/50 lg:hidden"></div>

        {{-- Main --}}
        <div class="flex min-w-0 flex-1 flex-col">
            <header class="sticky top-0 z-20 flex h-16 items-center justify-between gap-4 border-b border-sand-200 bg-sand-50/85 px-5 backdrop-blur-md lg:px-8">
                <div class="flex min-w-0 items-center gap-3">
                    <button @click="sidebar = !sidebar" class="-ml-1 rounded p-1.5 text-espresso-900/70 hover:bg-espresso-900/5 lg:hidden" aria-label="Menu">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <div class="min-w-0">
                        <h1 class="truncate text-lg font-semibold leading-tight text-espresso-900">{{ $title }}</h1>
                        @if($subtitle)<p class="truncate text-xs text-espresso-900/45">{{ $subtitle }}</p>@endif
                    </div>
                </div>
                <div class="flex items-center gap-4">
                    <span class="hidden text-right sm:block">
                        <span class="block text-xs font-medium leading-tight">{{ auth()->user()->name }}</span>
                        <span class="block text-[11px] text-espresso-900/45">{{ auth()->user()->is_super_admin ? 'Super Administrador' : 'Administrador' }}</span>
                    </span>
                    <form method="post" action="{{ route('admin.logout') }}">
                        @csrf
                        <button class="border border-sand-300 px-3.5 py-1.5 text-[11px] font-semibold uppercase tracking-[.12em] text-espresso-900/70 transition hover:border-copper-400 hover:text-copper-700">Sair</button>
                    </form>
                </div>
            </header>

            <main class="mx-auto w-full max-w-6xl flex-1 p-5 sm:p-6 lg:p-10">
                @if(session('status'))
                    <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)" x-transition
                         class="mb-6 flex items-center justify-between border-l-2 border-copper-500 bg-white px-4 py-3 text-sm shadow-sm">
                        <span class="flex items-center gap-2"><svg class="h-4 w-4 text-copper-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>{{ session('status') }}</span>
                        <button @click="show = false" class="text-espresso-900/40 hover:text-espresso-900">&times;</button>
                    </div>
                @endif
                {{ $slot }}
            </main>
        </div>
    </div>
</body>
</html>
