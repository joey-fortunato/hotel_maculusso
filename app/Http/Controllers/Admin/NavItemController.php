<?php

namespace App\Http\Controllers\Admin;

final class NavItemController extends ResourceController
{
    protected function model(): string { return \App\Models\NavItem::class; }
    protected function route(): string { return 'nav-items'; }
    protected function labels(): array { return ['Item de menu', 'Menu de navegação']; }
    protected function titleField(): string { return 'label'; }
    protected function fields(): array
    {
        return [
            ['name' => 'label', 'label' => 'Texto', 'type' => 'text', 'required' => true, 'translatable' => true],
            ['name' => 'route', 'label' => 'Nome da rota (ex: rooms.index)', 'type' => 'text', 'required' => true],
            ['name' => 'pattern', 'label' => 'Padrão activo (ex: rooms.*)', 'type' => 'text'],
            ['name' => 'is_published', 'label' => 'Visível', 'type' => 'checkbox'],
        ];
    }
}
