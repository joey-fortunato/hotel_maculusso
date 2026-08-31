<x-layouts.public :title="$page->tr('title').' | '.setting('name')">
    <x-public.header :locale="$locale" />
    <main>
        <x-public.page-hero
            :eyebrow="$page->eyebrow"
            :title="$page->tr('title')"
            :body="$page->tr('intro')"
            :image="img_src($page->image)" />

        <section class="mx-auto max-w-3xl px-6 py-20 lg:py-28">
            <div class="space-y-12">
                @foreach($page->tr('sections') ?? [] as $section)
                    <div>
                        <p class="eyebrow text-copper-600">{{ $section['title'] }}</p>
                        <span class="rule-copper mt-4"></span>
                        <p class="mt-5 text-lg leading-8 text-espresso-900/75">{{ $section['body'] }}</p>
                    </div>
                @endforeach
            </div>
            <p class="mt-16 border-t border-sand-200 pt-8 text-sm text-espresso-900/50">{{ __('Para qualquer questão, contacte-nos através de') }} <a href="mailto:{{ setting('email') }}" class="text-copper-600 underline underline-offset-4">{{ setting('email') }}</a>.</p>
        </section>
    </main>
    <x-public.footer :locale="$locale" />
</x-layouts.public>
