<?php

namespace App\Http\Controllers\Admin;

final class TestimonialController extends ResourceController
{
    protected function model(): string { return \App\Models\Testimonial::class; }
    protected function route(): string { return 'testimonials'; }
    protected function labels(): array { return ['Testemunho', 'Testemunhos']; }
    protected function titleField(): string { return 'name'; }
    protected function fields(): array
    {
        return [
            ['name' => 'quote', 'label' => 'Citação', 'type' => 'textarea', 'required' => true, 'translatable' => true],
            ['name' => 'name', 'label' => 'Nome', 'type' => 'text', 'required' => true],
            ['name' => 'role', 'label' => 'Contexto (ex: Estadia de negócios)', 'type' => 'text', 'translatable' => true],
            ['name' => 'is_published', 'label' => 'Publicado', 'type' => 'checkbox'],
        ];
    }
}
