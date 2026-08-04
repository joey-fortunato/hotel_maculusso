@props(['locale'])
@php
    $nav = \App\Models\NavItem::published()->ordered()->get()->map(fn ($item) => [
        'label' => $item->tr('label'),
        'url' => \Illuminate\Support\Facades\Route::has($item->route) ? route($item->route, $locale) : '#',
        'pattern' => $item->pattern ?: $item->route,
    ]);

    // Same page, other language
    $routeName = \Illuminate\Support\Facades\Route::currentRouteName() ?: 'home';
    $routeParams = request()->route()?->parameters() ?? [];
    $langUrl = fn (string $loc) => route($routeName, array_merge($routeParams, ['locale' => $loc]));
    $languages = ['pt' => 'Português', 'en' => 'English'];
@endphp
<header
    x-data="{ scrolled: false, open: false, lang: false }"
    x-init="scrolled = window.scrollY > 24"
    @scroll.window="scrolled = window.scrollY > 24"
    @keydown.escape.window="open = false"
    :class="scrolled || open ? 'bg-sand-50/95 text-espresso-900 shadow-sm backdrop-blur border-espresso-900/5' : 'bg-transparent text-white border-transparent'"
    class="fixed inset-x-0 top-0 z-50 border-b transition-colors duration-500">
    <div class="mx-auto flex max-w-7xl items-center justify-between px-6 py-3.5 lg:px-10">
        <a href="{{ route('home', $locale) }}" class="block" aria-label="Maculusso Hotel — página inicial">
            <img src="{{ asset('images/brand/maculusso-logo.png') }}" alt="Maculusso Hotel"
                 class="brand-logo transition duration-500" :class="scrolled || open ? '' : 'logo-invert'">
        </a>

        <nav class="hidden items-center gap-8 text-[11px] font-semibold uppercase tracking-[.16em] lg:flex" aria-label="Navegação principal">
            @foreach($nav as $item)
                <a class="nav-link" href="{{ $item['url'] }}" @if(request()->routeIs($item['pattern'])) data-active aria-current="page" @endif>{{ $item['label'] }}</a>
            @endforeach
        </nav>

        <div class="hidden items-center gap-6 lg:flex">
            {{-- Language switcher --}}
            <div class="relative" @click.outside="lang = false">
                <button type="button" @click="lang = !lang"
                        class="flex items-center gap-1.5 font-caps text-[11px] font-semibold uppercase tracking-[.16em] transition hover:text-copper-400"
                        aria-haspopup="true" :aria-expanded="lang">
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><circle cx="12" cy="12" r="9"/><path stroke-linecap="round" d="M3 12h18M12 3c2.5 2.5 2.5 15 0 18M12 3c-2.5 2.5-2.5 15 0 18"/></svg>
                    {{ strtoupper($locale) }}
                    <svg class="h-3 w-3 transition-transform duration-300" :class="lang ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/></svg>
                </button>
                <div x-show="lang" x-cloak
                     class="absolute right-0 top-full z-50 mt-3 w-40 border border-sand-200 bg-sand-50 py-1 text-espresso-900 shadow-xl">
                    @foreach($languages as $code => $label)
                        <a href="{{ $langUrl($code) }}"
                           class="flex items-center justify-between px-4 py-2.5 text-sm transition hover:bg-sand-100 {{ $code === $locale ? 'font-semibold text-copper-700' : 'text-espresso-900/70' }}">
                            {{ $label }}
                            @if($code === $locale)
                                <svg class="h-4 w-4 text-copper-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                            @endif
                        </a>
                    @endforeach
                </div>
            </div>
            <button type="button" @click="$store.booking.openModal()"
                    class="btn"
                    :class="scrolled || open ? 'btn-gold' : 'btn-outline'">{{ __('Reservar') }}</button>
        </div>

        <button @click="open = !open" class="-mr-2 rounded p-2 lg:hidden" :aria-expanded="open" aria-label="Abrir menu de navegação">
            <span class="block h-px w-6 bg-current transition" :class="open ? 'translate-y-[3px] rotate-45' : ''"></span>
            <span class="mt-1.5 block h-px w-6 bg-current transition" :class="open ? '-translate-y-[3px] -rotate-45' : ''"></span>
        </button>
    </div>

    <!-- Mobile drawer -->
    <div x-show="open" x-transition.opacity x-cloak
         class="border-t border-espresso-900/10 bg-sand-50 px-6 pb-8 pt-2 text-espresso-900 lg:hidden">
        <nav class="flex flex-col divide-y divide-espresso-900/10 text-sm font-medium" aria-label="Navegação móvel">
            @foreach($nav as $item)
                <a href="{{ $item['url'] }}" @click="open = false"
                   class="py-3.5 font-caps uppercase tracking-[.14em] {{ request()->routeIs($item['pattern']) ? 'text-copper-600' : '' }}">{{ $item['label'] }}</a>
            @endforeach
        </nav>
        <button type="button" @click="open = false; $store.booking.openModal()" class="btn btn-gold mt-6 w-full">{{ __('Reservar a sua estadia') }}</button>
        <div class="mt-5 inline-flex border border-sand-300">
            @foreach($languages as $code => $label)
                <a href="{{ $langUrl($code) }}"
                   class="px-4 py-2 font-caps text-[11px] font-semibold uppercase tracking-[.14em] transition {{ $code === $locale ? 'bg-copper-500 text-white' : 'text-espresso-900/60 hover:bg-sand-100' }}">{{ strtoupper($code) }}</a>
            @endforeach
        </div>
    </div>
</header>
