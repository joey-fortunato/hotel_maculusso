<?php

namespace App\Http\Controllers\Admin;

final class AmenityController extends ResourceController
{
    protected function model(): string { return \App\Models\Amenity::class; }
    protected function route(): string { return 'amenities'; }
    protected function labels(): array { return ['Comodidade', 'Comodidades']; }
    protected function titleField(): string { return 'label'; }
    protected function fields(): array
    {
        return [
            ['name' => 'label', 'label' => 'Nome', 'type' => 'text', 'required' => true, 'translatable' => true],
            ['name' => 'body', 'label' => 'Descrição curta', 'type' => 'textarea', 'translatable' => true],
            ['name' => 'is_published', 'label' => 'Publicado', 'type' => 'checkbox'],
        ];
    }
}
