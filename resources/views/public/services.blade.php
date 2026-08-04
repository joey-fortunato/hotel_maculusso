<x-layouts.public :title="'Serviços | '.setting('name')">
    <x-public.header :locale="$locale" />
    <main>
        <x-public.page-hero
            :eyebrow="__('Serviços')"
            :title="setting('services_hero_title')"
            :body="setting('services_hero_body')"
            :image="img_src(setting('services_hero_image'))" />

        <section class="mx-auto max-w-7xl px-6 py-24 lg:px-10 lg:py-32">
            <div class="mx-auto max-w-2xl text-center">
                <p class="eyebrow text-copper-600">{{ __('Categorias de serviços') }}</p>
                <span class="rule-copper mx-auto mt-5"></span>
                <h2 class="mt-6 font-display text-4xl leading-tight sm:text-5xl">{{ __('Tudo o que torna a estadia mais simples.') }}</h2>
            </div>

            <div class="mt-16 grid gap-px overflow-hidden border border-sand-200 bg-sand-200 sm:grid-cols-2">
                @foreach(\App\Models\Service::published()->ordered()->get() as $i => $service)
                    <div class="bg-sand-50 p-10 lg:p-12">
                        <span class="font-caps text-sm text-copper-500">{{ str_pad($i + 1, 2, '0', STR_PAD_LEFT) }}</span>
                        <h3 class="mt-4 font-display text-3xl leading-tight">{{ $service->tr('title') }}</h3>
                        <p class="mt-4 leading-8 text-espresso-900/70">{{ $service->tr('body') }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        {{-- Feature band --}}
        <section class="bg-espresso-900 text-white">
            <div class="mx-auto grid max-w-7xl gap-8 px-6 py-20 sm:grid-cols-2 lg:grid-cols-4 lg:px-10">
                @foreach([
                    ['Piscina', 'Um momento de pausa, ao seu ritmo.'],
                    ['Ginásio', 'Energia para acompanhar a sua viagem.'],
                    ['Wi-Fi & estacionamento', 'Sempre ligado. Sempre com espaço.'],
                    ['Transfer & concierge', 'Chegue e parta com total tranquilidade.'],
                ] as [$t, $b])
                    <div class="border-t border-copper-500/40 pt-5">
                        <p class="font-caps text-sm uppercase tracking-[.16em] text-copper-400">{{ $t }}</p>
                        <p class="mt-3 leading-7 text-sand-200/75">{{ $b }}</p>
                    </div>
                @endforeach
            </div>
        </section>

        <x-public.cta :locale="$locale" />
    </main>
    <x-public.footer :locale="$locale" />
</x-layouts.public>
