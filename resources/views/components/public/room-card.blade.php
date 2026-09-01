@props(['room', 'locale'])
@php $en = app()->getLocale() === 'en'; @endphp
<a href="{{ lroute('rooms.show', ['slug' => $room['slug']]) }}"
   class="group relative isolate flex aspect-square flex-col justify-end overflow-hidden bg-espresso-900 text-white shadow-sm transition duration-500 hover:shadow-xl">
    {{-- Image fills the card, stays visible; gradient only for legibility --}}
    <img src="{{ img_src($room->image) }}" alt="{{ $room->tr('name') }}" loading="lazy"
         class="absolute inset-0 -z-20 h-full w-full object-cover transition duration-700 group-hover:scale-105">
    <div class="absolute inset-0 -z-10 bg-gradient-to-t from-espresso-900 via-espresso-900/45 to-espresso-900/5"></div>

    {{-- Máx. guests badge --}}
    <span class="absolute right-5 top-5 inline-flex items-center gap-1.5 bg-espresso-900/60 px-3.5 py-2 text-xs font-semibold uppercase tracking-[.12em] text-copper-400 ring-1 ring-white/10 backdrop-blur">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><circle cx="9" cy="8" r="2.6"/><path stroke-linecap="round" d="M4 18a5 5 0 0 1 10 0M15 7.2a2.6 2.6 0 0 1 0 4.9M20 18a5 5 0 0 0-3.5-4.8"/></svg>
        {{ $en ? 'Max.' : 'Máx.' }} {{ $room->max_guests }}
    </span>

    {{-- Content --}}
    <div class="relative flex items-end justify-between gap-4 p-7 sm:p-8">
        <div class="min-w-0">
            <h3 class="font-display text-3xl leading-tight sm:text-4xl">{{ $room->tr('name') }}</h3>
            <p class="mt-2.5 line-clamp-2 max-w-sm leading-relaxed text-white/70">{{ $room->tr('description') }}</p>
        </div>

        <span aria-hidden="true"
              class="hidden h-14 w-14 shrink-0 place-items-center border border-white/40 text-white transition duration-300 group-hover:border-copper-400 group-hover:bg-copper-500 group-hover:text-white sm:grid">
            <svg class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/></svg>
        </span>
    </div>
</a>
