@props(['locale', 'title' => null, 'body' => null])
<section class="relative isolate overflow-hidden bg-espresso-900 px-6 py-24 text-center text-white lg:py-32">
    <img src="{{ img_src(setting('cta_image', 'https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=2200&q=80')) }}" alt="" loading="lazy" class="absolute inset-0 -z-20 h-full w-full object-cover opacity-25">
    <div class="absolute inset-0 -z-10 bg-espresso-900/70"></div>
    <p class="eyebrow text-copper-400">{{ setting('cta_eyebrow', __('A sua próxima estadia')) }}</p>
    <span class="rule-copper mx-auto mt-5"></span>
    <h2 class="mx-auto mt-6 max-w-3xl font-display text-4xl leading-tight sm:text-5xl">{{ $title ?? setting('cta_title', __('Reserve o tempo para aquilo que realmente importa.')) }}</h2>
    <p class="mx-auto mt-5 max-w-xl leading-8 text-sand-200/80">{{ $body ?? setting('cta_body', __('A sua próxima estadia começa aqui. Reserve directamente e deixe o resto connosco.')) }}</p>
    <button type="button" @click="$store.booking.openModal()" class="btn btn-gold mt-9">{{ __('Reservar agora') }}</button>
</section>
