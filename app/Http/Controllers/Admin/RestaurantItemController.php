<?php

namespace App\Http\Controllers\Admin;

final class RestaurantItemController extends ResourceController
{
    protected function model(): string { return \App\Models\RestaurantItem::class; }
    protected function route(): string { return 'restaurant-items'; }
    protected function labels(): array { return ['Componente', 'Restaurante']; }
    protected function fields(): array
    {
        return [
            ['name' => 'eyebrow', 'label' => 'Sobre-título (ex: Manhã)', 'type' => 'text', 'translatable' => true],
            ['name' => 'title', 'label' => 'Título', 'type' => 'text', 'required' => true, 'translatable' => true],
            ['name' => 'body', 'label' => 'Texto', 'type' => 'textarea', 'translatable' => true],
            ['name' => 'image', 'label' => 'Imagem', 'type' => 'image'],
            ['name' => 'is_published', 'label' => 'Publicado', 'type' => 'checkbox'],
        ];
    }
}
