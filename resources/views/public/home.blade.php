@php
    $amenities = \App\Models\Amenity::published()->ordered()->get();
    $testimonials = \App\Models\Testimonial::published()->ordered()->get()
        ->map(fn ($t) => ['quote' => $t->tr('quote'), 'name' => $t->name, 'role' => $t->tr('role')])->values();
@endphp
<x-layouts.public :title="setting('name').' | O seu lar longe de casa, em Luanda'">
    <x-public.header :locale="$locale" />
    <main>
        {{-- Hero + booking bar --}}
        <section class="relative isolate flex min-h-[100svh] flex-col items-center justify-center bg-espresso-900 px-6 py-32 text-center text-white">
            <img src="{{ img_src(setting('hero_image')) }}" alt="Suite do Maculusso Hotel em Luanda" class="absolute inset-0 -z-20 h-full w-full object-cover" fetchpriority="high">
            <div class="absolute inset-0 -z-10 bg-gradient-to-b from-espresso-900/80 via-espresso-900/45 to-espresso-900"></div>

            <p class="eyebrow text-copper-400">{{ setting('hero_eyebrow') }}</p>
            <span class="rule-copper mx-auto mt-6"></span>
            <h1 class="mx-auto mt-7 max-w-4xl font-display text-4xl leading-[1.05] sm:text-5xl lg:text-6xl">
                {{ setting('hero_title') }}<br class="hidden sm:block">
                <span class="text-white">{{ setting('hero_title_accent') }}</span>
            </h1>
            <p class="mx-auto mt-6 max-w-xl text-lg leading-8 text-sand-200/85">
                {{ setting('hero_subtitle') }}
            </p>

            {{-- Booking bar (custom controls — feeds the reservation modal) --}}
            <div x-data="bookingBar" class="mx-auto mt-11 w-full max-w-4xl">
                <div @click.outside="open = null"
                     class="grid gap-4 bg-espresso-900/40 p-4 text-left ring-1 ring-white/15 backdrop-blur sm:grid-cols-[1fr_1fr_1fr_auto] sm:items-end">

                    {{-- Check-in --}}
                    <div class="relative">
                        <span class="field-label-dark">{{ __('Check-in') }}</span>
                        <button type="button" @click="toggle('checkin', 'checkin')"
                                class="field-dark flex items-center justify-between gap-3" :class="open === 'checkin' ? 'border-copper-400' : ''">
                            <span x-text="fmt(b().checkin)"></span>
                            <svg class="h-4 w-4 text-copper-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 3v3M17 3v3M4 8h16M5 5h14a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1z"/></svg>
                        </button>
                        <div x-show="open === 'checkin'" x-cloak
                             class="absolute left-0 top-full z-40 mt-2 w-72 border border-sand-200 bg-white p-4 text-espresso-900 shadow-xl">
                            <x-public.calendar field="checkin" />
                        </div>
                    </div>

                    {{-- Check-out --}}
                    <div class="relative">
                        <span class="field-label-dark">{{ __('Check-out') }}</span>
                        <button type="button" @click="toggle('checkout', 'checkout')"
                                class="field-dark flex items-center justify-between gap-3" :class="open === 'checkout' ? 'border-copper-400' : ''">
                            <span x-text="fmt(b().checkout)"></span>
                            <svg class="h-4 w-4 text-copper-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M7 3v3M17 3v3M4 8h16M5 5h14a1 1 0 0 1 1 1v13a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1z"/></svg>
                        </button>
                        <div x-show="open === 'checkout'" x-cloak
                             class="absolute left-0 top-full z-40 mt-2 w-72 border border-sand-200 bg-white p-4 text-espresso-900 shadow-xl">
                            <x-public.calendar field="checkout" />
                        </div>
                    </div>

                    {{-- Guests --}}
                    <div class="relative">
                        <span class="field-label-dark">{{ __('Hóspedes') }}</span>
                        <button type="button" @click="toggle('guests')"
                                class="field-dark flex items-center justify-between gap-3" :class="open === 'guests' ? 'border-copper-400' : ''">
                            <span x-text="$store.booking.guestLabel(b().guests)"></span>
                            <svg class="h-4 w-4 text-copper-400 transition" :class="open === 'guests' ? 'rotate-180' : ''" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 9l6 6 6-6"/></svg>
                        </button>
                        <div x-show="open === 'guests'" x-cloak
                             class="absolute left-0 top-full z-40 mt-2 w-full border border-sand-200 bg-white text-espresso-900 shadow-xl">
                            <template x-for="n in 4" :key="n">
                                <button type="button" @click="setGuests(n)"
                                        class="flex w-full items-center justify-between px-4 py-3 text-sm transition hover:bg-sand-100"
                                        :class="b().guests === n ? 'text-copper-600' : ''">
                                    <span x-text="$store.booking.guestLabel(n)"></span>
                                    <svg x-show="b().guests === n" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.8" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                </button>
                            </template>
                        </div>
                    </div>

                    <button type="button" @click="$store.booking.openModal()" class="btn btn-gold h-12">{{ __('Reservar') }}</button>
                </div>
            </div>
        </section>

        {{-- Amenities strip --}}
        <section class="border-b border-sand-200 bg-white">
            <div class="mx-auto grid max-w-7xl grid-cols-2 divide-x divide-sand-200 px-6 lg:grid-cols-4 lg:px-10">
                @foreach([['+30', __('Quartos & suites')], ['24h', __('Receção sempre presente')], [__('Piscina'), __('& ginásio')], [__('Bar'), __('Cocktail lounge')]] as [$big, $small])
                    <div class="py-8 text-center">
                        <p class="font-display text-3xl text-copper-600">{{ $big }}</p>
                        <p class="mt-1 text-xs uppercase tracking-[.16em] text-espresso-900/50">{{ $small }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Welcome + arch image --}}
        <section class="mx-auto grid max-w-7xl gap-12 px-6 py-24 lg:grid-cols-2 lg:items-center lg:gap-20 lg:px-10 lg:py-32">
            <div class="mx-auto w-full max-w-sm">
                <div class="arch-top overflow-hidden">
                    <img src="{{ img_src(setting('welcome_image')) }}" alt="Interior acolhedor do Maculusso Hotel" loading="lazy" class="aspect-[3/4] h-full w-full object-cover">
                </div>
            </div>
            <div>
                <p class="eyebrow text-copper-600">{{ setting('welcome_eyebrow') }}</p>
                <span class="rule-copper mt-5"></span>
                <h2 class="mt-6 font-display text-4xl leading-tight sm:text-5xl">{{ setting('welcome_title') }}</h2>
                <p class="mt-6 leading-8 text-espresso-900/70">{{ setting('welcome_body') }}</p>
                <a href="{{ lroute('about') }}" class="link-arrow mt-8">{{ __('A nossa história') }} <span aria-hidden="true">&rarr;</span></a>
            </div>
        </section>

        {{-- Rooms --}}
        <section class="bg-sand-100 py-24 lg:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-10">
                <div class="flex flex-wrap items-end justify-between gap-6">
                    <div>
                        <p class="eyebrow text-copper-600">{{ setting('rooms_home_eyebrow') }}</p>
                        <span class="rule-copper mt-5"></span>
                        <h2 class="mt-6 max-w-xl font-display text-4xl leading-tight sm:text-5xl">{{ setting('rooms_home_title') }}</h2>
                    </div>
                    <a href="{{ lroute('rooms.index') }}" class="link-arrow hidden sm:inline-flex">{{ __('Ver todos') }} <span aria-hidden="true">&rarr;</span></a>
                </div>
                <div class="mt-12 grid gap-7 sm:grid-cols-2">
                    @foreach($rooms as $room)
                        <x-public.room-card :room="$room" :locale="$locale" />
                    @endforeach
                </div>
            </div>
        </section>

        {{-- Dining --}}
        <section class="bg-espresso-900 text-white">
            <div class="mx-auto grid max-w-7xl gap-12 px-6 py-24 lg:grid-cols-2 lg:items-center lg:gap-20 lg:px-10 lg:py-32">
                <div>
                    <p class="eyebrow text-copper-400">{{ setting('dining_eyebrow') }}</p>
                    <span class="rule-copper mt-5"></span>
                    <h2 class="mt-6 font-display text-4xl leading-tight sm:text-5xl">{{ setting('dining_title') }}</h2>
                    <p class="mt-6 max-w-lg leading-8 text-sand-200/80">{{ setting('dining_body') }}</p>
                    <a href="{{ lroute('restaurant') }}" class="btn btn-gold mt-8">{{ __('Explorar o restaurante') }}</a>
                </div>
                <img src="{{ img_src(setting('dining_image')) }}" alt="Ambiente do restaurante" loading="lazy" class="aspect-[4/3] h-full w-full object-cover">
            </div>
        </section>

        {{-- Comfort / amenities --}}
        <section class="mx-auto max-w-7xl px-6 py-24 lg:px-10 lg:py-32">
            <div class="mx-auto max-w-2xl text-center">
                <p class="eyebrow text-copper-600">{{ setting('comfort_eyebrow') }}</p>
                <span class="rule-copper mx-auto mt-5"></span>
                <h2 class="mt-6 font-display text-4xl leading-tight sm:text-5xl">{{ setting('comfort_title') }}</h2>
                <p class="mt-5 leading-8 text-espresso-900/70">{{ setting('comfort_subtitle') }}</p>
            </div>
            <div class="mt-14 grid gap-x-8 gap-y-12 sm:grid-cols-2 lg:grid-cols-4">
                @foreach($amenities as $a)
                    <div>
                        <x-public.amenity-icon :name="$a->label" class="h-8 w-8 text-copper-500" />
                        <h3 class="mt-4 font-caps text-sm uppercase tracking-[.14em]">{{ $a->tr('label') }}</h3>
                        <p class="mt-2 text-sm leading-6 text-espresso-900/60">{{ $a->tr('body') }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Testimonials (centered slider) --}}
        <section class="bg-sand-100 py-24 lg:py-32">
            <div x-data="{ active: 0, items: {{ Illuminate\Support\Js::from($testimonials) }} }" class="mx-auto max-w-3xl px-6 text-center">
                <p class="eyebrow text-copper-600">{{ setting('testimonials_eyebrow') }}</p>
                <span class="rule-copper mx-auto mt-5"></span>
                <div class="mt-8 flex justify-center gap-1.5 text-copper-500" aria-hidden="true">
                    @for($i = 0; $i < 5; $i++)
                        <svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2l2.9 6.3 6.9.7-5.1 4.6 1.5 6.8L12 17.8 5.9 20.4l1.5-6.8L2.3 9l6.9-.7z"/></svg>
                    @endfor
                </div>
                <template x-for="(t, i) in items" :key="i">
                    <blockquote x-show="active === i" x-transition.opacity.duration.500ms class="mt-8">
                        <p class="font-display text-2xl leading-relaxed text-espresso-800 sm:text-3xl" x-text="'“' + t.quote + '”'"></p>
                        <footer class="mt-8">
                            <p class="font-caps text-sm uppercase tracking-[.16em]" x-text="t.name"></p>
                            <p class="mt-1 text-xs uppercase tracking-[.16em] text-espresso-900/45" x-text="t.role"></p>
                        </footer>
                    </blockquote>
                </template>
                <div class="mt-10 flex justify-center gap-2.5">
                    <template x-for="(t, i) in items" :key="i">
                        <button @click="active = i" :aria-label="'Testemunho ' + (i + 1)"
                                class="h-2 w-2 rounded-full transition"
                                :class="active === i ? 'bg-copper-500 w-6' : 'bg-espresso-900/20 hover:bg-espresso-900/40'"></button>
                    </template>
                </div>
            </div>
        </section>

        <x-public.cta :locale="$locale" />
    </main>
    <x-public.footer :locale="$locale" />
</x-layouts.public>
