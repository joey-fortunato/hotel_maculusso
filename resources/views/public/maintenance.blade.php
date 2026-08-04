<!doctype html>
<html lang="pt" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex">
    <title>{{ setting('name') }} — Em manutenção</title>
    <link rel="icon" href="{{ asset('images/brand/maculusso-logo.png') }}" type="image/png">
    @vite(['resources/css/app.css'])
</head>
<body class="relative grid min-h-screen place-items-center overflow-hidden bg-espresso-900 px-6 text-center text-white">
    <img src="{{ img_src(setting('maintenance_image', setting('hero_image'))) }}" alt="" class="absolute inset-0 -z-20 h-full w-full object-cover">
    <div class="absolute inset-0 -z-10 bg-espresso-900/85"></div>

    <div class="mx-auto max-w-xl">
        <img src="{{ asset('images/brand/maculusso-logo.png') }}" alt="{{ setting('name') }}" class="mx-auto h-16 w-auto logo-invert">
        <p class="eyebrow mt-10 text-copper-400">{{ setting('maintenance_eyebrow', 'Voltamos em breve') }}</p>
        <span class="rule-copper mx-auto mt-5"></span>
        <h1 class="mt-6 font-display text-4xl leading-tight sm:text-5xl">{{ setting('maintenance_title', 'Estamos a preparar algo especial.') }}</h1>
        <p class="mt-5 leading-8 text-sand-200/80">{{ setting('maintenance_message', 'O nosso site está temporariamente em manutenção. Para reservas ou informações, a nossa equipa continua ao seu dispor.') }}</p>

        <div class="mt-9 flex flex-col items-center justify-center gap-3 sm:flex-row sm:gap-8">
            <a href="tel:{{ setting('phone_link') }}" class="font-caps text-sm uppercase tracking-[.16em] transition hover:text-copper-400">{{ setting('phone') }}</a>
            <span class="hidden h-4 w-px bg-white/20 sm:block"></span>
            <a href="mailto:{{ setting('email') }}" class="font-caps text-sm uppercase tracking-[.16em] transition hover:text-copper-400">{{ setting('email') }}</a>
        </div>
    </div>
</body>
</html>
