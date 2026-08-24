<x-layouts.public :title="'Restaurante & Bar | '.setting('name')">
    <x-public.header :locale="$locale" />
    <main>
        <x-public.page-hero
            :eyebrow="__('Restaurante & cocktail bar')"
            :title="setting('restaurant_hero_title')"
            :body="setting('restaurant_hero_body')"
            :image="img_src(setting('restaurant_hero_image'))" />

        <section class="mx-auto grid max-w-7xl gap-12 px-6 py-24 lg:grid-cols-2 lg:items-center lg:gap-20 lg:px-10 lg:py-32">
            <div class="mx-auto w-full max-w-sm">
                <div class="arch-top overflow-hidden">
                    <img src="{{ img_src(setting('restaurant_intro_image', 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?auto=format&fit=crop&w=1000&q=85')) }}" alt="{{ setting('restaurant_intro_title') }}" loading="lazy" class="aspect-[3/4] h-full w-full object-cover">
                </div>
            </div>
            <div>
                <p class="eyebrow text-copper-600">{{ setting('restaurant_intro_eyebrow', 'Gastronomia') }}</p>
                <span class="rule-copper mt-5"></span>
                <h2 class="mt-6 font-display text-4xl leading-tight sm:text-5xl">{{ setting('restaurant_intro_title', 'Uma experiência culinária única.') }}</h2>
                <p class="mt-6 leading-8 text-espresso-900/70">{{ setting('restaurant_intro_body', 'O nosso restaurante oferece uma variedade de pratos deliciosos, preparados com ingredientes frescos e de alta qualidade. Da cozinha angolana aos clássicos internacionais, cada refeição é pensada para ser recordada.') }}</p>
                <a href="{{ route('booking') }}" class="btn btn-gold mt-8">{{ __('Reservar mesa') }}</a>
            </div>
        </section>

        {{-- Restaurant experiences — zig-zag --}}
        <section class="bg-sand-100 py-24 lg:py-32">
            <div class="mx-auto max-w-7xl space-y-20 px-6 lg:space-y-28 lg:px-10">
                @foreach(\App\Models\RestaurantItem::published()->ordered()->get() as $item)
                    <div class="grid gap-10 lg:grid-cols-2 lg:items-center lg:gap-20">
                        <div class="overflow-hidden {{ $loop->even ? 'lg:order-2' : '' }}">
                            <img src="{{ img_src($item->image) }}" alt="{{ $item->title }}" loading="lazy"
                                 class="aspect-[4/3] w-full object-cover">
                        </div>
                        <div class="{{ $loop->even ? 'lg:order-1' : '' }}">
                            <p class="eyebrow text-copper-600">{{ $item->tr('eyebrow') }}</p>
                            <span class="rule-copper mt-5"></span>
                            <h3 class="mt-6 font-display text-4xl leading-tight sm:text-5xl">{{ $item->tr('title') }}</h3>
                            <p class="mt-5 max-w-lg leading-8 text-espresso-900/70">{{ $item->tr('body') }}</p>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <x-public.cta :locale="$locale" title="Reserve a sua mesa no Maculusso." body="Junte-se a nós para uma refeição memorável ou um cocktail ao fim do dia." />
    </main>
    <x-public.footer :locale="$locale" />
</x-layouts.public>
