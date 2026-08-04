@php
    $images = \App\Models\GalleryImage::published()->ordered()->get()
        ->map(fn ($g) => ['src' => img_src($g->image), 'caption' => $g->tr('caption'), 'tall' => (bool) $g->tall])
        ->values();
@endphp
<x-layouts.public :title="'Galeria | '.setting('name')">
    <x-public.header :locale="$locale" />
    <main>
        <x-public.page-hero
            :eyebrow="__('Galeria')"
            :title="setting('gallery_hero_title')"
            :body="setting('gallery_hero_body')"
            :image="img_src(setting('gallery_hero_image'))" />

        <section x-data="lightbox({{ Illuminate\Support\Js::from($images) }})" class="mx-auto max-w-7xl px-6 py-20 lg:px-10 lg:py-28">
            <div class="columns-1 gap-4 sm:columns-2 lg:columns-3 [&>*]:mb-4">
                @foreach($images as $i => $shot)
                    <button type="button" @click="show({{ $i }})"
                            class="group relative block w-full break-inside-avoid overflow-hidden focus:outline-none focus-visible:ring-2 focus-visible:ring-copper-400">
                        <img src="{{ $shot['src'] }}" alt="{{ $shot['caption'] }}" loading="lazy"
                             class="w-full object-cover transition duration-700 group-hover:scale-105 {{ $shot['tall'] ? 'aspect-[3/4]' : 'aspect-[4/3]' }}">
                        <span class="pointer-events-none absolute inset-0 bg-espresso-900/0 transition duration-500 group-hover:bg-espresso-900/20"></span>
                        <span class="pointer-events-none absolute left-1/2 top-1/2 grid h-11 w-11 -translate-x-1/2 -translate-y-1/2 place-items-center rounded-full bg-white/90 text-espresso-900 opacity-0 transition duration-500 group-hover:opacity-100">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-4.3-4.3M11 18a7 7 0 1 0 0-14 7 7 0 0 0 0 14zM11 8v6M8 11h6"/></svg>
                        </span>
                        @if($shot['caption'])
                            <span class="absolute inset-x-0 bottom-0 bg-gradient-to-t from-espresso-900/80 to-transparent p-5 text-left font-caps text-xs uppercase tracking-[.16em] text-white">{{ $shot['caption'] }}</span>
                        @endif
                    </button>
                @endforeach
            </div>

            {{-- Lightbox --}}
            <template x-teleport="body">
                <div x-show="open" x-cloak
                     class="fixed inset-0 z-[90] flex items-center justify-center bg-espresso-900/95 backdrop-blur-sm"
                     @keydown.escape.window="close()" @keydown.arrow-right.window="next()" @keydown.arrow-left.window="prev()"
                     x-effect="document.body.style.overflow = open ? 'hidden' : ''"
                     role="dialog" aria-modal="true" aria-label="Galeria de imagens">

                    <button @click="close()" aria-label="Fechar" class="absolute right-5 top-5 grid h-11 w-11 place-items-center rounded-full text-white ring-1 ring-white/25 transition hover:bg-white/10">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></svg>
                    </button>

                    <button @click="prev()" aria-label="Anterior" class="absolute left-3 top-1/2 grid h-12 w-12 -translate-y-1/2 place-items-center rounded-full text-white ring-1 ring-white/25 transition hover:bg-white/10 sm:left-6">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 6l-6 6 6 6"/></svg>
                    </button>
                    <button @click="next()" aria-label="Seguinte" class="absolute right-3 top-1/2 grid h-12 w-12 -translate-y-1/2 place-items-center rounded-full text-white ring-1 ring-white/25 transition hover:bg-white/10 sm:right-6">
                        <svg class="h-6 w-6" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6"/></svg>
                    </button>

                    <figure class="mx-auto flex max-h-[86vh] max-w-5xl flex-col items-center px-14 sm:px-20" @click.self="close()">
                        <img :src="items[i]?.src" :alt="items[i]?.caption" class="max-h-[78vh] w-auto max-w-full object-contain shadow-2xl">
                        <figcaption class="mt-4 text-center text-sm text-sand-200/80">
                            <span x-show="items[i]?.caption" class="font-caps uppercase tracking-[.16em]" x-text="items[i]?.caption"></span>
                            <span class="ml-3 text-sand-200/45" x-text="(i + 1) + ' / ' + items.length"></span>
                        </figcaption>
                    </figure>
                </div>
            </template>
        </section>

        <x-public.cta :locale="$locale" />
    </main>
    <x-public.footer :locale="$locale" />
</x-layouts.public>
