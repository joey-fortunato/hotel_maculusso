@props(['field'])
{{-- Custom calendar, driven by the bookingBar Alpine component. $field = 'checkin' | 'checkout' --}}
<div>
    <div class="flex items-center justify-between">
        <button type="button" @click="prev()" aria-label="Mês anterior"
                class="grid h-8 w-8 place-items-center text-copper-600 transition hover:bg-sand-100">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M15 6l-6 6 6 6"/></svg>
        </button>
        <p class="font-caps text-xs font-semibold uppercase tracking-[.16em]" x-text="monthLabel"></p>
        <button type="button" @click="next()" aria-label="Mês seguinte"
                class="grid h-8 w-8 place-items-center text-copper-600 transition hover:bg-sand-100">
            <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="1.7" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 6l6 6-6 6"/></svg>
        </button>
    </div>

    <div class="mt-4 grid grid-cols-7 gap-1 text-center text-[10px] font-semibold uppercase tracking-wide text-espresso-900/40">
        <template x-for="(d, i) in wd" :key="i"><span x-text="d"></span></template>
    </div>

    <div class="mt-1 grid grid-cols-7 gap-1">
        <template x-for="(cell, idx) in cells" :key="idx">
            <div class="flex h-9 items-center justify-center">
                <button type="button" x-show="cell !== null"
                        @click="pick('{{ $field }}', cell)"
                        :disabled="disabled('{{ $field }}', cell)"
                        class="grid h-9 w-9 place-items-center text-sm transition"
                        :class="selected('{{ $field }}', cell)
                            ? 'bg-copper-500 text-white'
                            : (disabled('{{ $field }}', cell)
                                ? 'text-espresso-900/25 cursor-not-allowed'
                                : (inRange(cell) ? 'bg-sand-100 text-espresso-900 hover:bg-sand-200' : 'text-espresso-900 hover:bg-sand-100'))">
                    <span x-text="cell"></span>
                </button>
            </div>
        </template>
    </div>
</div>
