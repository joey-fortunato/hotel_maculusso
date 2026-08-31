<?php

namespace Database\Seeders;

use App\Models\Amenity;
use App\Models\GalleryImage;
use App\Models\NavItem;
use App\Models\Page;
use App\Models\RestaurantItem;
use App\Models\Room;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Testimonial;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CmsSeeder extends Seeder
{
    public function run(): void
    {
        $this->settings();
        $this->rooms();
        $this->services();
        $this->amenities();
        $this->testimonials();
        $this->restaurant();
        $this->gallery();
        $this->nav();
        $this->pages();
    }

    private function settings(): void
    {
        $settings = [
            'general' => [
                'name' => 'Maculusso Hotel',
                'phone' => '+244 923 000 000',
                'phone_link' => '+244923000000',
                'whatsapp' => 'https://wa.me/244923000000',
                'email' => 'reservas@hotelmaculusso.com',
                'address' => 'Bairro Maculusso, Luanda, Angola',
                'city' => 'Luanda',
                'booking_url' => 'https://www.booking.com/',
                'instagram' => 'https://instagram.com/',
                'facebook' => 'https://facebook.com/',
                'footer_tagline' => 'O seu lar longe de casa, no coração de Luanda. Um refúgio boutique de paz e elegância para viajantes exigentes.',
            ],
            'hero' => [
                'hero_eyebrow' => 'Maculusso Hotel · Luanda',
                'hero_title' => 'O seu destino preferencial para negócios,',
                'hero_title_accent' => 'elegante e moderno.',
                'hero_subtitle' => 'Um refúgio boutique de paz e elegância para expatriados e viajantes exigentes, no coração de Luanda.',
                'hero_image' => 'https://images.unsplash.com/photo-1611892440504-42a792e24d32?auto=format&fit=crop&w=2400&q=90',
            ],
            'home' => [
                'welcome_eyebrow' => 'Bem-vindo ao Maculusso',
                'welcome_title' => 'Um refúgio tranquilo para profissionais e viajantes.',
                'welcome_body' => 'Localizado no coração de Luanda, o Maculusso Hotel é um refúgio boutique onde a hospitalidade genuína encontra um ritmo mais tranquilo. A nossa reputação assenta em conforto, comodidades modernas e no orgulho de criar uma experiência acolhedora e personalizada.',
                'welcome_image' => 'https://images.unsplash.com/photo-1631049035182-249067d7618e?auto=format&fit=crop&w=1000&q=85',
                'rooms_home_eyebrow' => 'Quartos & suites',
                'rooms_home_title' => 'Refúgios de elegância para repousar e recomeçar.',
                'dining_eyebrow' => 'Gastronomia & cocktail bar',
                'dining_title' => 'Há encontros que começam à mesa.',
                'dining_body' => 'Cozinha de identidade angolana e internacional, ingredientes frescos e cocktails preparados com cuidado — num ambiente que convida a prolongar a conversa.',
                'dining_image' => 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1400&q=85',
                'comfort_eyebrow' => 'Comodidades',
                'comfort_title' => 'Tudo para o seu conforto.',
                'comfort_subtitle' => 'Comodidades modernas pensadas para que a sua estadia seja tão descansada quanto produtiva.',
                'testimonials_eyebrow' => 'Avaliações dos hóspedes',
                'testimonials_title' => 'Uma estadia que fica consigo.',
            ],
            'heroes' => [
                'rooms_hero_title' => 'Espaço para repousar. Detalhes para recordar.',
                'rooms_hero_body' => 'Mais de 30 quartos modernos e confortáveis, cada um pensado como um refúgio sereno no coração de Luanda.',
                'rooms_hero_image' => 'https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=2400&q=90',
                'services_hero_title' => 'Desfrute de serviços que elevam a sua experiência.',
                'services_hero_body' => 'No Maculusso, cada detalhe é pensado para tornar a sua estadia mais simples, tranquila e memorável.',
                'services_hero_image' => 'https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=2400&q=90',
                'restaurant_hero_title' => 'A mesa é sempre uma boa ideia.',
                'restaurant_hero_body' => 'Cozinha de identidade angolana e internacional, ingredientes frescos e o tipo de ambiente que convida a ficar mais um pouco.',
                'restaurant_hero_image' => 'https://images.unsplash.com/photo-1550966871-3ed3cdb5ed0c?auto=format&fit=crop&w=2400&q=90',
                'gallery_hero_title' => 'Veja como se sente ficar aqui.',
                'gallery_hero_body' => 'Uma colecção de momentos, espaços e pequenos detalhes que definem a experiência Maculusso.',
                'gallery_hero_image' => 'https://images.unsplash.com/photo-1564501049412-61c2a3083791?auto=format&fit=crop&w=2400&q=90',
                'about_hero_title' => 'O seu lar longe de casa, em Luanda.',
                'about_hero_body' => 'Um refúgio boutique que oferece paz e elegância para expatriados e viajantes exigentes.',
                'about_hero_image' => 'https://images.unsplash.com/photo-1566073771259-6a8506099945?auto=format&fit=crop&w=2400&q=90',
                'about_intro_title' => 'Hospitalidade, com um sentido mais humano.',
                'about_intro_body' => "Localizado no coração de Luanda, o Maculusso Hotel é um refúgio boutique que oferece paz e elegância para expatriados e viajantes exigentes.\n\nA nossa reputação assenta na tranquilidade, no conforto e nas comodidades modernas que nos diferenciam. Temos orgulho em criar uma experiência acolhedora e personalizada, para que cada hóspede se sinta verdadeiramente bem-vindo.",
                'about_image' => 'https://images.unsplash.com/photo-1445019980597-93fa8acb246c?auto=format&fit=crop&w=1000&q=85',
                'contact_hero_title' => 'Estamos aqui para o receber.',
                'contact_hero_body' => 'Para reservas, pedidos especiais ou simplesmente uma pergunta, fale connosco. A nossa equipa responde com prazer.',
                'contact_hero_image' => 'https://images.unsplash.com/photo-1600607687939-ce8a6c25118c?auto=format&fit=crop&w=2400&q=90',
                'blog_hero_title' => 'Ideias para viajar com mais vagar.',
                'blog_hero_body' => 'Histórias, sabores e roteiros para aproveitar melhor cada estadia e descobrir Luanda ao seu ritmo.',
                'blog_hero_image' => 'https://images.unsplash.com/photo-1518005020951-eccb494ad742?auto=format&fit=crop&w=2400&q=90',
            ],
            'blocks' => [
                'cta_eyebrow' => 'A sua próxima estadia',
                'cta_title' => 'Reserve o tempo para aquilo que realmente importa.',
                'cta_body' => 'A sua próxima estadia começa aqui. Reserve directamente e deixe o resto connosco.',
                'cta_image' => 'https://images.unsplash.com/photo-1582719508461-905c673771fd?auto=format&fit=crop&w=2200&q=80',
                'footer_reservas' => 'Reserve directamente e deixe o resto connosco.',
                'restaurant_intro_eyebrow' => 'Gastronomia',
                'restaurant_intro_title' => 'Uma experiência culinária única.',
                'restaurant_intro_body' => 'O nosso restaurante oferece uma variedade de pratos deliciosos, preparados com ingredientes frescos e de alta qualidade. Da cozinha angolana aos clássicos internacionais, cada refeição é pensada para ser recordada.',
                'restaurant_intro_image' => 'https://images.unsplash.com/photo-1414235077428-338989a2e8c0?auto=format&fit=crop&w=1000&q=85',
            ],
        ];

        foreach ($settings as $group => $pairs) {
            foreach ($pairs as $key => $value) {
                Setting::updateOrCreate(['key' => $key], ['value' => $value, 'group' => $group]);
            }
        }

        // English translations for the newly mapped blocks
        $en = [
            'cta_eyebrow' => 'Your next stay',
            'cta_title' => 'Reserve time for what truly matters.',
            'cta_body' => 'Your next stay starts here. Book directly and leave the rest to us.',
            'footer_reservas' => 'Book directly and leave the rest to us.',
            'restaurant_intro_eyebrow' => 'Gastronomy',
            'restaurant_intro_title' => 'A unique culinary experience.',
            'restaurant_intro_body' => 'Our restaurant offers a variety of delicious dishes, prepared with fresh, high-quality ingredients. From Angolan cuisine to international classics, every meal is made to be remembered.',
        ];
        foreach ($en as $key => $value) {
            Setting::putEn($key, $value);
        }
    }

    private function rooms(): void
    {
        foreach (array_values(config('hotel.rooms')) as $i => $r) {
            Room::updateOrCreate(['slug' => $r['slug']], [
                'name' => $r['name'],
                'tagline' => $r['tagline'],
                'price' => $r['price'],
                'price_double' => $r['price_double'],
                'max_guests' => $r['max_guests'],
                'detail' => $r['detail'],
                'guests' => $r['guests'],
                'size' => $r['size'],
                'bed' => $r['bed'],
                'image' => $r['image'],
                'description' => $r['description'],
                'amenities' => $r['amenities'],
                'sort' => $i,
                'is_published' => true,
            ]);
        }
    }

    private function services(): void
    {
        foreach (array_values(config('hotel.services')) as $i => $s) {
            Service::updateOrCreate(['title' => $s['title']], ['body' => $s['body'], 'sort' => $i]);
        }
    }

    private function amenities(): void
    {
        $items = [
            ['Piscina', 'Um espaço para pausar ao seu ritmo.'],
            ['Cocktail Bar', 'Lounge sofisticado ao fim do dia.'],
            ['Ginásio', 'Energia para acompanhar a viagem.'],
            ['Wi-Fi', 'Ligação de alta velocidade em todo o hotel.'],
            ['Serviço de Quartos', 'Atenção discreta, à hora que precisar.'],
            ['Segurança 24h', 'Tranquilidade a cada momento.'],
            ['Receção 24h', 'Uma equipa sempre presente.'],
            ['Lavandaria', 'Conforto cuidado até ao último detalhe.'],
        ];
        foreach ($items as $i => [$label, $body]) {
            Amenity::updateOrCreate(['label' => $label], ['body' => $body, 'sort' => $i]);
        }
    }

    private function testimonials(): void
    {
        $items = [
            ['A atenção aos detalhes fez toda a diferença. Sentimo-nos cuidados desde a chegada.', 'Hóspede Maculusso', 'Estadia de negócios'],
            ['Um espaço sereno, elegante e com uma equipa genuinamente prestável. Voltarei de certeza.', 'Hóspede Maculusso', 'Estadia prolongada'],
            ['O quarto, o restaurante e o acolhimento: tudo tornou a viagem mais leve.', 'Hóspede Maculusso', 'Fim de semana em Luanda'],
        ];
        foreach ($items as $i => [$quote, $name, $role]) {
            Testimonial::updateOrCreate(['quote' => $quote], ['name' => $name, 'role' => $role, 'sort' => $i]);
        }
    }

    private function restaurant(): void
    {
        $items = [
            ['Manhã', 'Pequeno-almoço', 'Comece o dia devagar, com uma mesa preparada todos os dias — fruta fresca, pão quente e o café como deve ser.', 'https://images.unsplash.com/photo-1533089860892-a7c6f0a88666?auto=format&fit=crop&w=1200&q=85'],
            ['Almoço & jantar', 'Restaurante', 'Cozinha com sabor, memória e intenção. Pratos de identidade angolana e clássicos internacionais, preparados com ingredientes frescos e de alta qualidade.', 'https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=1200&q=85'],
            ['Fim de tarde', 'Cocktail bar', 'O melhor lugar para terminar bem o dia. Uma selecção exclusiva de cocktails clássicos e criações da casa, num lounge sofisticado.', 'https://images.unsplash.com/photo-1470337458703-46ad1756a187?auto=format&fit=crop&w=1200&q=85'],
        ];
        foreach ($items as $i => [$eyebrow, $title, $body, $image]) {
            RestaurantItem::updateOrCreate(['title' => $title], ['eyebrow' => $eyebrow, 'body' => $body, 'image' => $image, 'sort' => $i]);
        }
    }

    private function gallery(): void
    {
        $items = [
            ['https://images.unsplash.com/photo-1631049307264-da0ec9d70304?auto=format&fit=crop&w=1200&q=85', 'Suite Deluxe', true],
            ['https://images.unsplash.com/photo-1590490360182-c33d57733427?auto=format&fit=crop&w=1200&q=85', 'Quarto Twin', false],
            ['https://images.unsplash.com/photo-1571896349842-33c89424de2d?auto=format&fit=crop&w=1200&q=85', 'Piscina', false],
            ['https://images.unsplash.com/photo-1414235077428-338989a2e8c0?auto=format&fit=crop&w=1200&q=85', 'Gastronomia', true],
            ['https://images.unsplash.com/photo-1470337458703-46ad1756a187?auto=format&fit=crop&w=1200&q=85', 'Cocktail bar', false],
            ['https://images.unsplash.com/photo-1618773928121-c32242e63f39?auto=format&fit=crop&w=1200&q=85', 'Suite Deluxe Plus', false],
            ['https://images.unsplash.com/photo-1540555700478-4be289fbecef?auto=format&fit=crop&w=1200&q=85', 'Ginásio', true],
            ['https://images.unsplash.com/photo-1445019980597-93fa8acb246c?auto=format&fit=crop&w=1200&q=85', 'Receção', false],
            ['https://images.unsplash.com/photo-1551882547-ff40c63fe5fa?auto=format&fit=crop&w=1200&q=85', 'Lounge', false],
        ];
        foreach ($items as $i => [$image, $caption, $tall]) {
            GalleryImage::updateOrCreate(['image' => $image], ['caption' => $caption, 'tall' => $tall, 'sort' => $i]);
        }
    }

    private function nav(): void
    {
        $items = [
            ['Início', 'Home', 'home', 'home'],
            ['Quartos', 'Rooms', 'rooms.index', 'rooms.*'],
            ['Serviços', 'Services', 'services.index', 'services.*'],
            ['Restaurante', 'Restaurant', 'restaurant', 'restaurant'],
            ['Galeria', 'Gallery', 'gallery', 'gallery'],
            ['Quem Somos', 'About', 'about', 'about'],
            ['Contactos', 'Contact', 'contact', 'contact'],
        ];
        foreach ($items as $i => [$label, $labelEn, $route, $pattern]) {
            NavItem::updateOrCreate(['label' => $label], ['label_en' => $labelEn, 'route' => $route, 'pattern' => $pattern, 'sort' => $i]);
        }
    }

    private function pages(): void
    {
        Page::updateOrCreate(['key' => 'privacy'], [
            'eyebrow' => 'Privacidade',
            'title' => 'Os seus dados, tratados com respeito.',
            'intro' => 'Usamos apenas a informação necessária para responder aos seus pedidos, gerir reservas e melhorar a sua experiência.',
            'image' => 'https://images.unsplash.com/photo-1556742049-0cfed4f6a45d?auto=format&fit=crop&w=2400&q=90',
            'sections' => [
                ['title' => 'Dados recolhidos', 'body' => 'Recolhemos apenas os dados que nos fornece directamente através de contactos e reservas — nome, contactos e informação relacionada com a sua estadia.'],
                ['title' => 'Finalidade', 'body' => 'Utilizamos os seus dados para comunicar consigo, confirmar reservas e prestar os serviços solicitados. Não partilhamos os seus dados com terceiros para fins de marketing.'],
                ['title' => 'Os seus direitos', 'body' => 'Pode a qualquer momento solicitar o acesso, a correcção ou a eliminação dos seus dados. Para tal, contacte-nos através do email de reservas.'],
            ],
        ]);

        Page::updateOrCreate(['key' => 'terms'], [
            'eyebrow' => 'Termos & condições',
            'title' => 'Clareza antes de cada estadia.',
            'intro' => 'As condições aplicáveis a reservas, cancelamentos e utilização do nosso website são apresentadas de forma simples.',
            'image' => 'https://images.unsplash.com/photo-1556761175-b413da4baf72?auto=format&fit=crop&w=2400&q=90',
            'sections' => [
                ['title' => 'Reservas', 'body' => 'Todas as reservas estão sujeitas a disponibilidade e a confirmação por parte do hotel.'],
                ['title' => 'Cancelamentos', 'body' => 'As condições de cancelamento dependem da tarifa e das condições escolhidas no momento da reserva.'],
                ['title' => 'Website', 'body' => 'O conteúdo deste website é protegido e destina-se a uso informativo. As imagens são meramente ilustrativas.'],
            ],
        ]);
    }
}
