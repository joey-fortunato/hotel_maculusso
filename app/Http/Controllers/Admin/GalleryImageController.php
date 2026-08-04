<?php

namespace App\Http\Controllers\Admin;

final class GalleryImageController extends ResourceController
{
    protected function model(): string { return \App\Models\GalleryImage::class; }
    protected function route(): string { return 'gallery'; }
    protected function labels(): array { return ['Imagem', 'Galeria']; }
    protected function titleField(): string { return 'caption'; }
    protected function fields(): array
    {
        return [
            ['name' => 'image', 'label' => 'Imagem', 'type' => 'image', 'required' => true],
            ['name' => 'caption', 'label' => 'Legenda', 'type' => 'text', 'translatable' => true],
            ['name' => 'tall', 'label' => 'Formato alto (retrato)', 'type' => 'checkbox'],
            ['name' => 'is_published', 'label' => 'Publicado', 'type' => 'checkbox'],
        ];
    }
}
