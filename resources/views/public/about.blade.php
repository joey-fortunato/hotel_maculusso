<x-layouts.public :title="'Quem Somos | '.setting('name')">
    <x-public.header :locale="$locale" />
    <main>
        <x-public.page-hero
            :eyebrow="__('Quem somos')"
            :title="setting('about_hero_title')"
            :body="setting('about_hero_body')"
            :image="img_src(setting('about_hero_image'))" />

        <section class="mx-auto grid max-w-7xl gap-12 px-6 py-24 lg:grid-cols-2 lg:items-center lg:gap-20 lg:px-10 lg:py-32">
            <div>
                <p class="eyebrow text-copper-600">{{ __('A nossa história') }}</p>
                <span class="rule-copper mt-5"></span>
                <h2 class="mt-6 font-display text-4xl leading-tight sm:text-5xl">{{ setting('about_intro_title') }}</h2>
                @foreach(preg_split('/\n\n+/', (string) setting('about_intro_body')) as $para)
                    <p class="mt-4 leading-8 text-espresso-900/70">{{ trim($para) }}</p>
                @endforeach
            </div>
            <div class="mx-auto w-full max-w-sm">
                <div class="arch-top overflow-hidden">
                    <img src="{{ img_src(setting('about_image')) }}" alt="{{ setting('name') }}" loading="lazy" class="aspect-[3/4] h-full w-full object-cover">
                </div>
            </div>
        </section>

        <section class="bg-sand-100 py-24 lg:py-32">
            <div class="mx-auto max-w-7xl px-6 lg:px-10">
                <div class="max-w-2xl">
                    <p class="eyebrow text-copper-600">{{ __('O que nos define') }}</p>
                    <span class="rule-copper mt-5"></span>
                    <h2 class="mt-6 font-display text-4xl leading-tight sm:text-5xl">{{ __('Oferecemos hospitalidade excepcional num ambiente tranquilo e sofisticado.') }}</h2>
                </div>
                <div class="mt-14 grid gap-10 sm:grid-cols-3">
                    @foreach([
                        [__('Calor humano'), __('Atenção presente, nunca invasiva. Uma equipa que antecipa o que precisa.')],
                        [__('Conforto genuíno'), __('Qualidade que se nota nos pequenos gestos e nas comodidades modernas.')],
                        [__('Ligação a Luanda'), __('Uma estadia com verdadeiro sentido de lugar, no coração da cidade.')],
                    ] as [$t, $b])
                        <div>
                            <span class="font-caps text-copper-500">·</span>
                            <h3 class="mt-2 font-display text-2xl leading-tight">{{ $t }}</h3>
                            <p class="mt-3 leading-7 text-espresso-900/70">{{ $b }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        <x-public.cta :locale="$locale" />
    </main>
    <x-public.footer :locale="$locale" />
</x-layouts.public>
