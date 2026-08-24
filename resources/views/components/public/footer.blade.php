@props(['locale'])
<footer class="bg-espresso-900 text-sand-200">
    <div class="mx-auto grid max-w-7xl gap-12 px-6 py-20 lg:grid-cols-[1.6fr_1fr_1fr_1.1fr] lg:px-10">
        <div>
            <img src="{{ asset('images/brand/maculusso-logo.png') }}" alt="Maculusso Hotel" class="h-14 w-auto logo-invert">
            <p class="mt-6 max-w-xs text-sm leading-7 text-sand-200/70">{{ setting('footer_tagline') }}</p>
        </div>
        <div>
            <p class="eyebrow text-copper-400">{{ __('Explorar') }}</p>
            <div class="mt-5 grid gap-3 text-sm">
                <a class="transition hover:text-copper-400" href="{{ route('rooms.index', $locale) }}">{{ __('Quartos & Suites') }}</a>
                <a class="transition hover:text-copper-400" href="{{ route('services.index', $locale) }}">{{ __('Serviços') }}</a>
                <a class="transition hover:text-copper-400" href="{{ route('restaurant', $locale) }}">{{ __('Restaurante') }}</a>
                <a class="transition hover:text-copper-400" href="{{ route('gallery', $locale) }}">{{ __('Galeria') }}</a>
                <a class="transition hover:text-copper-400" href="{{ route('about', $locale) }}">{{ __('Quem Somos') }}</a>
            </div>
        </div>
        <div>
            <p class="eyebrow text-copper-400">{{ __('Contactos') }}</p>
            <div class="mt-5 grid gap-3 text-sm">
                <a class="transition hover:text-copper-400" href="tel:{{ setting('phone_link') }}">{{ setting('phone') }}</a>
                <a class="transition hover:text-copper-400" href="mailto:{{ setting('email') }}">{{ setting('email') }}</a>
                <p class="text-sand-200/70">{{ setting('address') }}</p>
            </div>
        </div>
        <div>
            <p class="eyebrow text-copper-400">{{ __('Reservas') }}</p>
            <p class="mt-5 text-sm leading-7 text-sand-200/70">{{ setting('footer_reservas', __('Reserve directamente e deixe o resto connosco.')) }}</p>
            <button type="button" @click="$store.booking.openModal()" class="btn btn-gold mt-5">{{ __('Reservar agora') }}</button>
            <div class="mt-6 flex gap-4">
                <a href="{{ setting('instagram') }}" aria-label="Instagram" class="transition hover:text-copper-400"><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.2c3.2 0 3.6 0 4.9.1 1.2.1 1.8.3 2.2.4.6.2 1 .5 1.4.9.4.4.7.8.9 1.4.2.4.3 1 .4 2.2.1 1.3.1 1.7.1 4.9s0 3.6-.1 4.9c-.1 1.2-.3 1.8-.4 2.2-.2.6-.5 1-.9 1.4-.4.4-.8.7-1.4.9-.4.2-1 .3-2.2.4-1.3.1-1.7.1-4.9.1s-3.6 0-4.9-.1c-1.2-.1-1.8-.3-2.2-.4-.6-.2-1-.5-1.4-.9-.4-.4-.7-.8-.9-1.4-.2-.4-.3-1-.4-2.2C2.2 15.6 2.2 15.2 2.2 12s0-3.6.1-4.9c.1-1.2.3-1.8.4-2.2.2-.6.5-1 .9-1.4.4-.4.8-.7 1.4-.9.4-.2 1-.3 2.2-.4C8.4 2.2 8.8 2.2 12 2.2Zm0 1.8c-3.1 0-3.5 0-4.7.1-1.1.1-1.7.2-2.1.4-.5.2-.9.4-1.3.8-.4.4-.6.8-.8 1.3-.2.4-.3 1-.4 2.1C2.6 9.9 2.6 10.3 2.6 12s0 2.1.1 3.3c.1 1.1.2 1.7.4 2.1.2.5.4.9.8 1.3.4.4.8.6 1.3.8.4.2 1 .3 2.1.4 1.2.1 1.6.1 4.7.1s3.5 0 4.7-.1c1.1-.1 1.7-.2 2.1-.4.5-.2.9-.4 1.3-.8.4-.4.6-.8.8-1.3.2-.4.3-1 .4-2.1.1-1.2.1-1.6.1-3.3s0-2.1-.1-3.3c-.1-1.1-.2-1.7-.4-2.1-.2-.5-.4-.9-.8-1.3-.4-.4-.8-.6-1.3-.8-.4-.2-1-.3-2.1-.4-1.2-.1-1.6-.1-4.7-.1Zm0 3.1a4.9 4.9 0 1 1 0 9.8 4.9 4.9 0 0 1 0-9.8Zm0 8.1a3.2 3.2 0 1 0 0-6.4 3.2 3.2 0 0 0 0 6.4Zm6.2-8.3a1.15 1.15 0 1 1-2.3 0 1.15 1.15 0 0 1 2.3 0Z"/></svg></a>
                <a href="{{ setting('facebook') }}" aria-label="Facebook" class="transition hover:text-copper-400"><svg class="h-5 w-5" fill="currentColor" viewBox="0 0 24 24"><path d="M22 12a10 10 0 1 0-11.6 9.9v-7H7.9V12h2.5V9.8c0-2.5 1.5-3.9 3.8-3.9 1.1 0 2.2.2 2.2.2v2.4h-1.2c-1.2 0-1.6.8-1.6 1.6V12h2.7l-.4 2.9h-2.3v7A10 10 0 0 0 22 12Z"/></svg></a>
            </div>
        </div>
    </div>
    <div class="border-t border-sand-200/10 px-6 py-6 text-center text-xs tracking-wide text-sand-200/50">© {{ date('Y') }} {{ setting('name') }}. {{ __('Todos os direitos reservados.') }}</div>
</footer>
