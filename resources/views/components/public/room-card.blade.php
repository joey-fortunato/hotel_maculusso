@props(['room', 'locale'])
@php $en = app()->getLocale() === 'en'; @endphp
<a href="{{ route('rooms.show', [$locale, $room['slug']]) }}"
   class="group relative isolate flex min-h-[24rem] flex-col justify-end overflow-hidden bg-espresso-900 text-white shadow-sm transition duration-500 hover:shadow-xl sm:min-h-[27rem] lg:min-h-[30rem]">
    {{-- Image fills the card, stays visible; gradient only for legibility --}}
    <img src="{{ img_src($room->image) }}" alt="{{ $room->tr('name') }}" loading="lazy"
         class="absolute inset-0 -z-20 h-full w-full object-cover transition duration-700 group-hover:scale-105">
    <div class="absolute inset-0 -z-10 bg-gradient-to-t from-espresso-900 via-espresso-900/45 to-espresso-900/5"></div>

    {{-- Máx. guests badge --}}
    <span class="absolute right-4 top-4 inline-flex items-center gap-1.5 bg-espresso-900/60 px-3 py-1.5 text-[11px] font-semibold uppercase tracking-[.12em] text-copper-400 ring-1 ring-white/10 backdrop-blur sm:right-5 sm:top-5 sm:px-3.5 sm:py-2 sm:text-xs">
        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><circle cx="9" cy="8" r="2.6"/><path stroke-linecap="round" d="M4 18a5 5 0 0 1 10 0M15 7.2a2.6 2.6 0 0 1 0 4.9M20 18a5 5 0 0 0-3.5-4.8"/></svg>
        {{ $en ? 'Max.' : 'Máx.' }} {{ $room->max_guests }}
    </span>

    {{-- Content --}}
    <div class="relative p-6 sm:p-8">
        {{-- Tagline --}}
        @if($room->tr('tagline'))
            <p class="mb-2 text-[11px] font-semibold uppercase tracking-[.16em] text-copper-400">{{ $room->tr('tagline') }}</p>
        @endif
        <h3 class="font-display text-3xl leading-tight sm:text-4xl">{{ $room->tr('name') }}</h3>
        <p class="mt-3 line-clamp-2 max-w-md text-sm leading-relaxed text-white/70 sm:text-base">{{ $room->tr('description') }}</p>

        {{-- Prices + CTA --}}
        <div class="mt-6 flex items-end justify-between gap-4 border-t border-white/15 pt-5">
            <div class="flex divide-x divide-white/15">
                <div class="pr-5 sm:pr-6">
                    <p class="text-[10px] font-semibold uppercase tracking-[.12em] text-copper-400/80">{{ $en ? 'Single' : 'Individual' }}</p>
                    <p class="mt-1 text-base font-medium text-white sm:text-lg">{{ number_format($room->price, 0, ',', ' ') }} Kz</p>
                </div>
                <div class="pl-5 sm:pl-6">
                    <p class="text-[10px] font-semibold uppercase tracking-[.12em] text-copper-400/80">{{ $en ? 'Double' : 'Duplo' }}</p>
                    <p class="mt-1 text-base font-medium text-white sm:text-lg">{{ number_format($room->price_double, 0, ',', ' ') }} Kz</p>
                </div>
            </div>

            <span aria-hidden="true"
                  class="grid h-12 w-12 shrink-0 place-items-center border border-white/40 text-white transition duration-300 group-hover:border-copper-400 group-hover:bg-copper-500 group-hover:text-white sm:h-14 sm:w-14">
                <svg class="h-5 w-5 transition-transform duration-300 group-hover:translate-x-0.5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/></svg>
            </span>
        </div>
    </div>
</a>
