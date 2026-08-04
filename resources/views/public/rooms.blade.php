<x-layouts.public :title="'Quartos & Suites | '.setting('name')">
    <x-public.header :locale="$locale" />
    <main>
        <x-public.page-hero
            :eyebrow="__('Quartos & suites')"
            :title="setting('rooms_hero_title')"
            :body="setting('rooms_hero_body')"
            :image="img_src(setting('rooms_hero_image'))" />

        <section class="mx-auto max-w-7xl px-6 py-20 lg:px-10 lg:py-28">
            <div class="grid gap-7 sm:grid-cols-2">
                @foreach($rooms as $room)
                    <x-public.room-card :room="$room" :locale="$locale" />
                @endforeach
            </div>

            <div class="mt-16 grid gap-6 border-t border-sand-200 pt-14 sm:grid-cols-3">
                @foreach([
                    ['Check-in flexível', 'Chegada e partida ajustadas ao seu ritmo de viagem.'],
                    ['Comodidades modernas', 'Ar condicionado, Wi-Fi de alta velocidade e Smart TV em todos os quartos.'],
                    ['Serviço 24h', 'Uma equipa sempre presente, pronta para o que precisar.'],
                ] as [$t, $b])
                    <div>
                        <p class="eyebrow text-copper-600">{{ $t }}</p>
                        <p class="mt-3 leading-7 text-espresso-900/70">{{ $b }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <x-public.cta :locale="$locale" />
    </main>
    <x-public.footer :locale="$locale" />
</x-layouts.public>
