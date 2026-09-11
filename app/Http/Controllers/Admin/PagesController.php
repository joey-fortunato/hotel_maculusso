<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class PagesController extends Controller
{
    /**
     * Page tabs → blocks → fields. type: text | textarea | image
     */
    public static function tabs(): array
    {
        return [
            'inicio' => ['label' => 'Início', 'blocks' => [
                'Destaque (hero)' => [
                    'hero_eyebrow' => ['Sobre-título', 'text'],
                    'hero_title' => ['Título', 'textarea'],
                    'hero_title_accent' => ['Título — parte em destaque', 'text'],
                    'hero_title_size' => ['Tamanho do título', 'select', ['sm' => 'Pequeno', 'md' => 'Médio (padrão)', 'lg' => 'Grande']],
                    'hero_subtitle' => ['Subtítulo', 'textarea'],
                    'hero_image' => ['Imagem de fundo', 'image'],
                ],
                'Boas-vindas' => [
                    'welcome_eyebrow' => ['Sobre-título', 'text'],
                    'welcome_title' => ['Título', 'text'],
                    'welcome_body' => ['Texto', 'textarea'],
                    'welcome_image' => ['Imagem', 'image'],
                ],
                'Secção Quartos' => [
                    'rooms_home_eyebrow' => ['Sobre-título', 'text'],
                    'rooms_home_title' => ['Título', 'text'],
                ],
                'Secção Restaurante' => [
                    'dining_eyebrow' => ['Sobre-título', 'text'],
                    'dining_title' => ['Título', 'text'],
                    'dining_body' => ['Texto', 'textarea'],
                    'dining_image' => ['Imagem', 'image'],
                ],
                'Secção Conforto' => [
                    'comfort_eyebrow' => ['Sobre-título', 'text'],
                    'comfort_title' => ['Título', 'text'],
                    'comfort_subtitle' => ['Subtítulo', 'textarea'],
                ],
                'Secção Testemunhos' => [
                    'testimonials_eyebrow' => ['Sobre-título', 'text'],
                    'testimonials_title' => ['Título', 'text'],
                ],
            ]],
            'quartos' => ['label' => 'Quartos', 'blocks' => ['Cabeçalho' => [
                'rooms_hero_title' => ['Título', 'text'],
                'rooms_hero_body' => ['Texto', 'textarea'],
                'rooms_hero_image' => ['Imagem', 'image'],
            ]]],
            'servicos' => ['label' => 'Serviços', 'blocks' => ['Cabeçalho' => [
                'services_hero_title' => ['Título', 'text'],
                'services_hero_body' => ['Texto', 'textarea'],
                'services_hero_image' => ['Imagem', 'image'],
            ]]],
            'restaurante' => ['label' => 'Restaurante', 'blocks' => [
                'Cabeçalho' => [
                    'restaurant_hero_title' => ['Título', 'text'],
                    'restaurant_hero_body' => ['Texto', 'textarea'],
                    'restaurant_hero_image' => ['Imagem', 'image'],
                ],
                'Introdução (Gastronomia)' => [
                    'restaurant_intro_eyebrow' => ['Sobre-título', 'text'],
                    'restaurant_intro_title' => ['Título', 'text'],
                    'restaurant_intro_body' => ['Texto', 'textarea'],
                    'restaurant_intro_image' => ['Imagem (arco)', 'image'],
                ],
            ]],
            'galeria' => ['label' => 'Galeria', 'blocks' => ['Cabeçalho' => [
                'gallery_hero_title' => ['Título', 'text'],
                'gallery_hero_body' => ['Texto', 'textarea'],
                'gallery_hero_image' => ['Imagem', 'image'],
            ]]],
            'sobre' => ['label' => 'Quem Somos', 'blocks' => [
                'Cabeçalho' => [
                    'about_hero_title' => ['Título', 'text'],
                    'about_hero_body' => ['Texto', 'textarea'],
                    'about_hero_image' => ['Imagem', 'image'],
                ],
                'A nossa história' => [
                    'about_intro_title' => ['Título', 'text'],
                    'about_intro_body' => ['Texto (parágrafos separados por linha em branco)', 'textarea'],
                    'about_image' => ['Imagem', 'image'],
                ],
            ]],
            'contactos' => ['label' => 'Contactos', 'blocks' => ['Cabeçalho' => [
                'contact_hero_title' => ['Título', 'text'],
                'contact_hero_body' => ['Texto', 'textarea'],
                'contact_hero_image' => ['Imagem', 'image'],
            ]]],
            'geral' => ['label' => 'Geral', 'blocks' => [
                'Marca & contactos' => [
                    'name' => ['Nome do hotel', 'text'],
                    'email' => ['Email de reservas', 'text'],
                    'phone' => ['Telefone (apresentação)', 'text'],
                    'phone_link' => ['Telefone (link)', 'text'],
                    'whatsapp' => ['Link do WhatsApp', 'text'],
                    'address' => ['Morada', 'text'],
                    'booking_url' => ['URL de reservas externo', 'text'],
                    'instagram' => ['Instagram', 'text'],
                    'facebook' => ['Facebook', 'text'],
                    'footer_tagline' => ['Texto do rodapé', 'textarea'],
                    'footer_reservas' => ['Rodapé — texto de Reservas', 'textarea'],
                ],
                'Bloco de reserva (fim de todas as páginas)' => [
                    'cta_eyebrow' => ['Sobre-título', 'text'],
                    'cta_title' => ['Título', 'text'],
                    'cta_body' => ['Texto', 'textarea'],
                    'cta_image' => ['Imagem de fundo', 'image'],
                ],
            ]],
        ];
    }

    public function edit(): View
    {
        return view('admin.pages', [
            'tabs' => static::tabs(),
            'legal' => Page::orderBy('key')->get()->keyBy('key'),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        foreach (static::tabs() as $tab) {
            foreach ($tab['blocks'] as $fields) {
                foreach ($fields as $key => [$label, $type]) {
                    if ($type === 'image' && $request->hasFile("file_{$key}")) {
                        Setting::put($key, '/storage/'.$request->file("file_{$key}")->store('cms', 'public'), 'settings');

                        continue;
                    }
                    if ($request->has($key)) {
                        Setting::put($key, $request->input($key), 'settings');
                    }
                    if ($type !== 'image' && $request->has("en_{$key}")) {
                        Setting::putEn($key, $request->input("en_{$key}"));
                    }
                }
            }
        }

        // Legal pages
        foreach ((array) $request->input('legal', []) as $key => $data) {
            $page = Page::where('key', $key)->first();
            if (! $page) {
                continue;
            }
            $sections = [];
            $sectionsEn = [];
            foreach ($data['section_title'] ?? [] as $i => $title) {
                $title = trim((string) $title);
                $body = trim((string) ($data['section_body'][$i] ?? ''));
                if ($title !== '' || $body !== '') {
                    $sections[] = ['title' => $title, 'body' => $body];
                    $sectionsEn[] = [
                        'title' => trim((string) ($data['section_title_en'][$i] ?? '')),
                        'body' => trim((string) ($data['section_body_en'][$i] ?? '')),
                    ];
                }
            }
            $page->update([
                'title' => $data['title'] ?? $page->title,
                'title_en' => $data['title_en'] ?? null,
                'intro' => $data['intro'] ?? null,
                'intro_en' => $data['intro_en'] ?? null,
                'sections' => $sections,
                'sections_en' => $sectionsEn,
            ]);
        }

        return back()->with('status', 'Alterações guardadas.');
    }
}
