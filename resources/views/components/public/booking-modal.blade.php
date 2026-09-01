{{-- Global reservation modal. Driven by $store.booking; rendered once in the layout. --}}
<div x-data
     x-show="$store.booking.open"
     x-cloak
     class="fixed inset-0 z-[80] flex items-start justify-center overflow-y-auto p-4 sm:items-center sm:p-6"
     @keydown.escape.window="$store.booking.close()"
     x-effect="document.body.style.overflow = $store.booking.open ? 'hidden' : ''"
     role="dialog" aria-modal="true" aria-label="Fazer reserva">

    {{-- Overlay --}}
    <div x-show="$store.booking.open" x-transition.opacity.duration.300ms
         class="fixed inset-0 bg-espresso-900/70 backdrop-blur-sm" @click="$store.booking.close()"></div>

    {{-- Panel --}}
    <div x-show="$store.booking.open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0 translate-y-4 sm:scale-95"
         x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
         class="relative my-8 w-full max-w-2xl border-t-2 border-copper-500 bg-sand-50 text-espresso-900 shadow-2xl ring-1 ring-espresso-900/10 sm:my-0">

        {{-- Header --}}
        <div class="flex items-start justify-between gap-4 border-b border-sand-200 px-6 py-5 sm:px-8">
            <div>
                <h2 class="font-display text-3xl leading-none">{{ __('Fazer Reserva') }}</h2>
                <p class="mt-1.5 text-sm text-espresso-900/55">{{ __('Escolha o seu quarto e deixe-nos os seus dados') }}</p>
            </div>
            <button @click="$store.booking.close()" aria-label="Fechar"
                    class="grid h-9 w-9 shrink-0 place-items-center rounded-full ring-1 ring-espresso-900/15 transition hover:bg-espresso-900/5">
                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" d="M6 6l12 12M18 6L6 18"/></svg>
            </button>
        </div>

        <div class="max-h-[74vh] overflow-y-auto px-6 py-6 sm:px-8">
            {{-- Success state --}}
            <template x-if="$store.booking.status === 'success'">
                <div class="py-10 text-center">
                    <span class="mx-auto grid h-14 w-14 place-items-center rounded-full bg-copper-500/12 text-copper-600 ring-1 ring-copper-500/30">
                        <svg class="h-7 w-7" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                    </span>
                    <h3 class="mt-6 font-display text-3xl leading-tight">{{ __('Pedido enviado') }}</h3>
                    <p class="mx-auto mt-3 max-w-md leading-7 text-espresso-900/65" x-text="$store.booking.message"></p>
                    <button @click="$store.booking.close()" class="btn btn-gold mt-8">{{ __('Concluir') }}</button>
                </div>
            </template>

            {{-- Booking form --}}
            <div x-show="$store.booking.status !== 'success'">
                {{-- Dates & guests (pre-filled from the booking bar) --}}
                <div class="grid gap-4 sm:grid-cols-3">
                    <div>
                        <span class="field-label">{{ __('Check-in') }}</span>
                        <input type="date" x-model="$store.booking.checkin" class="field">
                    </div>
                    <div>
                        <span class="field-label">{{ __('Check-out') }}</span>
                        <input type="date" x-model="$store.booking.checkout" :min="$store.booking.checkin" class="field">
                    </div>
                    <div>
                        <span class="field-label">{{ __('Hóspedes') }}</span>
                        <select x-model.number="$store.booking.guests" class="field">
                            <template x-for="n in 4" :key="n">
                                <option :value="n" x-text="$store.booking.guestLabel(n)"></option>
                            </template>
                        </select>
                    </div>
                </div>

                {{-- Room selection --}}
                <div class="mt-7 flex items-center justify-between gap-3">
                    <p class="field-label mb-0">{{ __('Seleccione o quarto') }}</p>
                    <p class="text-xs text-espresso-900/50">
                        <span x-text="$store.booking.occupancyLabel"></span> · <span x-text="$store.booking.nightsLabel"></span>
                    </p>
                </div>

                <div class="mt-3 space-y-3">
                    <template x-for="room in $store.booking.availableRooms" :key="room.slug">
                        <button type="button" @click="$store.booking.select(room.slug)"
                                class="flex w-full items-center gap-4 border bg-white p-4 text-left transition"
                                :class="$store.booking.selected === room.slug ? 'border-copper-500 ring-1 ring-copper-500/30' : 'border-sand-200 hover:border-copper-400'">
                            <span class="grid h-11 w-11 shrink-0 place-items-center rounded-full transition"
                                  :class="$store.booking.selected === room.slug ? 'bg-copper-500 text-white' : 'text-copper-600 ring-1 ring-sand-300'">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10V7a1 1 0 0 1 1-1h16a1 1 0 0 1 1 1v3M3 10h18M3 10v7m18-7v7M3 14h18M7 10V8h4v2"/></svg>
                            </span>
                            <span class="min-w-0 flex-1">
                                <span class="flex flex-wrap items-baseline justify-between gap-x-3">
                                    <span class="font-display text-lg leading-tight" x-text="room.name"></span>
                                </span>
                                <span class="mt-0.5 flex flex-wrap items-baseline justify-between gap-x-3">
                                    <span class="text-xs uppercase tracking-[.12em] text-espresso-900/50" x-text="$store.booking.maxLabel(room.max_guests)"></span>
                                </span>
                                <span class="mt-1.5 block text-sm leading-relaxed text-espresso-900/55" x-text="room.description"></span>
                            </span>
                        </button>
                    </template>
                    <p x-show="$store.booking.availableRooms.length === 0" class="border border-sand-200 bg-white p-6 text-center text-sm text-espresso-900/60">
                        {{ __('Nenhum quarto disponível para esta ocupação. Ajuste o número de hóspedes ou fale connosco.') }}
                    </p>
                </div>

                {{-- Guest details --}}
                <p class="field-label mt-8">{{ __('Os seus dados') }}</p>
                <div class="grid gap-4 sm:grid-cols-2">
                    <div class="sm:col-span-2">
                        <input type="text" x-model="$store.booking.name" placeholder="{{ __('Nome completo') }}" class="field"
                               :class="$store.booking.errors.name ? 'border-red-500' : ''">
                        <p x-show="$store.booking.errors.name" x-text="$store.booking.errors.name?.[0]" class="mt-1.5 text-xs text-red-600"></p>
                    </div>
                    <div>
                        <input type="email" x-model="$store.booking.email" placeholder="{{ __('Email') }}" class="field"
                               :class="$store.booking.errors.email ? 'border-red-500' : ''">
                        <p x-show="$store.booking.errors.email" x-text="$store.booking.errors.email?.[0]" class="mt-1.5 text-xs text-red-600"></p>
                    </div>
                    <div>
                        <input type="tel" x-model="$store.booking.phone" placeholder="{{ __('Telefone') }}" class="field"
                               :class="$store.booking.errors.phone ? 'border-red-500' : ''">
                        <p x-show="$store.booking.errors.phone" x-text="$store.booking.errors.phone?.[0]" class="mt-1.5 text-xs text-red-600"></p>
                    </div>
                </div>

                {{-- Error banner --}}
                <p x-show="$store.booking.status === 'error'" x-transition x-text="$store.booking.message"
                   class="mt-5 border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700"></p>

                <button type="button" @click="$store.booking.submit()"
                        :disabled="$store.booking.status === 'sending'"
                        class="btn btn-gold mt-6 w-full disabled:cursor-not-allowed disabled:opacity-60">
                    <span x-show="$store.booking.status !== 'sending'">{{ __('Fazer pedido de reserva') }}</span>
                    <span x-show="$store.booking.status === 'sending'">{{ __('A processar…') }}</span>
                </button>
                <p class="mt-3 text-center text-xs leading-6 text-espresso-900/45">{{ __('Receberá um contacto da nossa equipa para confirmar a disponibilidade. Nenhum pagamento é feito nesta etapa.') }}</p>
            </div>
        </div>
    </div>
</div>
