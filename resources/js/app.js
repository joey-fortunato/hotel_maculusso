import './bootstrap';
import Alpine from 'alpinejs';

const pad = (n) => String(n).padStart(2, '0');
const toISO = (d) => `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}`;

Alpine.store('booking', {
    open: false,
    rooms: window.HOTEL_ROOMS || [],
    checkin: '',
    checkout: '',
    guests: 1,
    selected: null,          // slug of the chosen room
    name: '',
    email: '',
    phone: '',
    status: 'idle',          // idle | sending | success | error
    message: '',
    errors: {},

    init() {
        const today = new Date();
        const out = new Date();
        out.setDate(today.getDate() + 2);
        this.checkin = toISO(today);
        this.checkout = toISO(out);
    },

    get en() {
        return (window.APP_LOCALE || 'pt') === 'en';
    },

    get nights() {
        if (!this.checkin || !this.checkout) return 0;
        const diff = (new Date(this.checkout) - new Date(this.checkin)) / 86400000;
        return diff > 0 ? Math.round(diff) : 0;
    },

    get nightsLabel() {
        const n = this.nights;
        if (n <= 0) return '—';
        const word = n === 1 ? (this.en ? 'night' : 'noite') : (this.en ? 'nights' : 'noites');
        return `${n} ${word}`;
    },

    guestLabel(n) {
        const word = n === 1 ? (this.en ? 'Guest' : 'Hóspede') : (this.en ? 'Guests' : 'Hóspedes');
        return `${n} ${word}`;
    },

    maxLabel(max) {
        return `${this.en ? 'Max.' : 'Máx.'} ${max} ${this.en ? 'Guests' : 'Hóspedes'}`;
    },

    money(value) {
        return `${new Intl.NumberFormat('pt-PT').format(value)} Kz`;
    },

    // Individual rate for 1 guest, double rate for 2+
    get occupancyLabel() {
        if (this.guests >= 2) return this.en ? 'Double occupancy' : 'Ocupação dupla';
        return this.en ? 'Single occupancy' : 'Ocupação individual';
    },

    priceFor(room) {
        return this.guests >= 2 ? (room.price_double ?? room.price) : room.price;
    },

    total(price) {
        return this.money(price * Math.max(this.nights, 1));
    },

    get availableRooms() {
        return this.rooms.filter((r) => r.max_guests >= this.guests);
    },

    get selectedRoom() {
        return this.rooms.find((r) => r.slug === this.selected) || null;
    },

    // Open the modal, optionally with a room pre-selected
    openModal(slug = null) {
        if (slug) this.selected = slug;
        this.status = 'idle';
        this.message = '';
        this.errors = {};
        this.open = true;
    },

    close() {
        this.open = false;
    },

    select(slug) {
        this.selected = slug;
    },

    async submit() {
        this.errors = {};
        this.message = '';

        if (!this.selected) {
            this.status = 'error';
            this.message = 'Por favor, seleccione um quarto antes de continuar.';
            return;
        }

        this.status = 'sending';

        try {
            const res = await fetch(window.RESERVATION_URL, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                    'X-CSRF-TOKEN': window.CSRF_TOKEN,
                },
                body: JSON.stringify({
                    room: this.selected,
                    checkin: this.checkin,
                    checkout: this.checkout,
                    guests: this.guests,
                    name: this.name,
                    email: this.email,
                    phone: this.phone,
                    website: '', // honeypot — stays empty for real users
                    _ts: window.FORM_TS,
                }),
            });

            if (res.ok) {
                this.status = 'success';
                this.message = 'Pedido de reserva enviado! A nossa equipa entrará em contacto em breve para confirmar a sua estadia.';
                this.name = this.email = this.phone = '';
            } else if (res.status === 422) {
                const data = await res.json();
                this.errors = data.errors || {};
                this.status = 'error';
                this.message = Object.keys(this.errors).length
                    ? 'Verifique os campos assinalados e tente novamente.'
                    : (data.message || 'Não foi possível processar o pedido. Tente novamente.');
            } else if (res.status === 429) {
                this.status = 'error';
                this.message = 'Demasiados pedidos. Aguarde um momento e tente novamente.';
            } else {
                this.status = 'error';
                this.message = 'Ocorreu um erro ao processar o pedido. Tente novamente.';
            }
        } catch (e) {
            this.status = 'error';
            this.message = 'Não foi possível enviar o pedido. Verifique a sua ligação e tente novamente.';
        }
    },
});

// Booking bar with custom date-picker + guest select (no native browser chrome)
Alpine.data('bookingBar', () => ({
    open: null, // 'checkin' | 'checkout' | 'guests' | null
    viewY: 2026,
    viewM: 0,
    wd: ['S', 'T', 'Q', 'Q', 'S', 'S', 'D'],
    mo: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
    moShort: ['Jan', 'Fev', 'Mar', 'Abr', 'Mai', 'Jun', 'Jul', 'Ago', 'Set', 'Out', 'Nov', 'Dez'],

    init() {
        const d = new Date();
        this.viewY = d.getFullYear();
        this.viewM = d.getMonth();
        if ((window.APP_LOCALE || 'pt') === 'en') {
            this.wd = ['M', 'T', 'W', 'T', 'F', 'S', 'S'];
            this.mo = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
            this.moShort = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];
        }
    },

    b() {
        return this.$store.booking;
    },

    fmt(iso) {
        if (!iso) return '—';
        const d = new Date(iso + 'T00:00:00');
        return `${pad(d.getDate())} ${this.moShort[d.getMonth()]} ${d.getFullYear()}`;
    },

    toggle(panel, key) {
        if (this.open === panel) {
            this.open = null;
            return;
        }
        this.open = panel;
        const cur = key ? this.b()[key] : null;
        if (cur) {
            const d = new Date(cur + 'T00:00:00');
            this.viewY = d.getFullYear();
            this.viewM = d.getMonth();
        }
    },

    prev() {
        if (--this.viewM < 0) { this.viewM = 11; this.viewY--; }
    },
    next() {
        if (++this.viewM > 11) { this.viewM = 0; this.viewY++; }
    },

    get monthLabel() {
        return `${this.mo[this.viewM]} ${this.viewY}`;
    },

    get cells() {
        const first = new Date(this.viewY, this.viewM, 1);
        const offset = (first.getDay() + 6) % 7; // Monday-first
        const days = new Date(this.viewY, this.viewM + 1, 0).getDate();
        const arr = [];
        for (let i = 0; i < offset; i++) arr.push(null);
        for (let d = 1; d <= days; d++) arr.push(d);
        return arr;
    },

    isoOf(day) {
        return `${this.viewY}-${pad(this.viewM + 1)}-${pad(day)}`;
    },

    todayISO() {
        const d = new Date();
        return `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}`;
    },

    disabled(key, day) {
        if (day === null) return true;
        const iso = this.isoOf(day);
        if (key === 'checkin') return iso < this.todayISO();
        return iso <= (this.b().checkin || this.todayISO());
    },

    selected(key, day) {
        return day !== null && this.isoOf(day) === this.b()[key];
    },

    inRange(day) {
        if (day === null) return false;
        const iso = this.isoOf(day);
        return this.b().checkin && this.b().checkout && iso > this.b().checkin && iso < this.b().checkout;
    },

    pick(key, day) {
        if (this.disabled(key, day)) return;
        const iso = this.isoOf(day);
        this.b()[key] = iso;
        if (key === 'checkin' && (!this.b().checkout || this.b().checkout <= iso)) {
            const d = new Date(iso + 'T00:00:00');
            d.setDate(d.getDate() + 1);
            this.b().checkout = `${d.getFullYear()}-${pad(d.getMonth() + 1)}-${pad(d.getDate())}`;
        }
        this.open = key === 'checkin' ? 'checkout' : null;
    },

    setGuests(n) {
        this.b().guests = n;
        this.open = null;
    },
}));

// Gallery lightbox
Alpine.data('lightbox', (items = []) => ({
    items,
    open: false,
    i: 0,

    show(index) {
        this.i = index;
        this.open = true;
    },
    close() {
        this.open = false;
    },
    next() {
        this.i = (this.i + 1) % this.items.length;
    },
    prev() {
        this.i = (this.i - 1 + this.items.length) % this.items.length;
    },
}));

window.Alpine = Alpine;
Alpine.start();
