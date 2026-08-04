<?php

namespace App\Http\Controllers\Admin;

final class ServiceController extends ResourceController
{
    protected function model(): string { return \App\Models\Service::class; }
    protected function route(): string { return 'services'; }
    protected function labels(): array { return ['Serviço', 'Serviços']; }
    protected function fields(): array
    {
        return [
            ['name' => 'title', 'label' => 'Título', 'type' => 'text', 'required' => true, 'translatable' => true],
            ['name' => 'body', 'label' => 'Descrição', 'type' => 'textarea', 'translatable' => true],
            ['name' => 'is_published', 'label' => 'Publicado', 'type' => 'checkbox'],
        ];
    }
}
