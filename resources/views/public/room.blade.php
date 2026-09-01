@php
    $amenitiesPt = $room->amenities ?? [];
    $amenitiesTr = $room->tr('amenities') ?: $amenitiesPt;
@endphp
<x-layouts.public :title="$room->tr('name').' | '.setting('name')">
    <x-public.header :locale="$locale" />
    <main>
        <x-public.page-hero
            :eyebrow="$room->tr('tagline')"
            :title="$room->tr('name')"
            :body="$room->detailLine()"
            :image="img_src($room->image)" />

        <section class="mx-auto max-w-6xl px-6 py-20 lg:px-10 lg:py-28">
            <a href="{{ lroute('rooms.index') }}" class="link-arrow"><span aria-hidden="true">&larr;</span> {{ __('Todos os quartos') }}</a>

            <div class="mt-12 grid gap-14 lg:grid-cols-[1.4fr_1fr] lg:gap-20">
                <div>
                    <div class="overflow-hidden">
                        <img src="{{ img_src($room->image) }}" alt="{{ $room->tr('name') }}" class="aspect-[3/2] w-full object-cover">
                    </div>

                    {{-- Photo gallery --}}
                    @if(!empty($room->gallery))
                        <div class="mt-4 grid grid-cols-4 gap-3">
                            @foreach($room->gallery as $shot)
                                <div class="overflow-hidden">
                                    <img src="{{ img_src($shot) }}" alt="{{ $room->tr('name') }}" loading="lazy"
                                         class="aspect-square w-full object-cover transition duration-500 hover:scale-105 hover:brightness-105">
                                </div>
                            @endforeach
                        </div>
                    @endif

                    <h2 class="mt-12 font-display text-3xl leading-tight sm:text-4xl">{{ __('Um quarto pensado para o descanso.') }}</h2>
                    <p class="mt-6 max-w-2xl leading-8 text-espresso-900/70">{{ $room->tr('description') }}</p>

                    <p class="eyebrow mt-12 text-copper-600">{{ __('Comodidades') }}</p>
                    <span class="rule-copper mt-4"></span>
                    <ul class="mt-6 grid gap-x-8 gap-y-4 text-espresso-900/80 sm:grid-cols-2">
                        @foreach($amenitiesPt as $i => $amenity)
                            <li class="flex items-center gap-3 border-b border-sand-200 pb-4">
                                <x-public.amenity-icon :name="$amenity" class="h-5 w-5 shrink-0 text-copper-500" />
                                {{ $amenitiesTr[$i] ?? $amenity }}
                            </li>
                        @endforeach
                    </ul>
                </div>

                <aside class="lg:sticky lg:top-28 lg:self-start">
                    <div class="border border-sand-200 bg-white p-8 shadow-sm">
                        <p class="eyebrow text-copper-600">{{ __('Detalhes do quarto') }}</p>
                        <dl class="mt-6 grid gap-4 text-sm">
                            <div class="flex justify-between border-b border-sand-200 pb-4"><dt class="text-espresso-900/50">{{ __('Ocupação') }}</dt><dd class="font-semibold">{{ $room->guestsLabel() }}</dd></div>
                            <div class="flex justify-between border-b border-sand-200 pb-4"><dt class="text-espresso-900/50">{{ __('Área') }}</dt><dd class="font-semibold">{{ $room->size }}</dd></div>
                            <div class="flex justify-between"><dt class="text-espresso-900/50">{{ __('Cama') }}</dt><dd class="font-semibold">{{ $room->tr('bed') }}</dd></div>
                        </dl>
                        <button type="button" @click="$store.booking.openModal('{{ $room->slug }}')" class="btn btn-gold mt-8 w-full">{{ __('Reservar este quarto') }}</button>
                        <a href="{{ setting('whatsapp') }}" class="mt-3 block text-center text-xs font-semibold uppercase tracking-[.16em] text-espresso-900/50 transition hover:text-copper-600">{{ __('Falar por WhatsApp') }}</a>
                    </div>
                </aside>
            </div>
        </section>

        <x-public.cta :locale="$locale" />
    </main>
    <x-public.footer :locale="$locale" />
</x-layouts.public>
