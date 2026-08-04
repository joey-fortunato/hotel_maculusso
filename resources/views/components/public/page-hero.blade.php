@props(['eyebrow', 'title', 'body' => null, 'image'])
<section class="relative isolate overflow-hidden bg-espresso-900 text-white">
    <img src="{{ $image }}" alt="" class="absolute inset-0 -z-20 h-full w-full object-cover opacity-45" fetchpriority="high">
    <div class="absolute inset-0 -z-10 bg-gradient-to-b from-espresso-900/70 via-espresso-900/40 to-espresso-900/85"></div>
    <div class="mx-auto max-w-7xl px-6 pb-20 pt-40 lg:px-10 lg:pb-28 lg:pt-52">
        <p class="eyebrow text-copper-400">{{ $eyebrow }}</p>
        <span class="rule-copper mt-5"></span>
        <h1 class="mt-6 max-w-4xl font-display text-5xl leading-[1.05] sm:text-6xl lg:text-7xl">{{ $title }}</h1>
        @if($body)
            <p class="mt-6 max-w-2xl text-lg leading-8 text-sand-200/85">{{ $body }}</p>
        @endif
    </div>
</section>
