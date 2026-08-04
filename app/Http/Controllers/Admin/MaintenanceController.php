<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

final class MaintenanceController extends Controller
{
    /** Editable content fields for the maintenance screen. */
    public static function fields(): array
    {
        return [
            'maintenance_image' => ['Imagem de fundo', 'image'],
            'maintenance_eyebrow' => ['Sobre-título', 'text'],
            'maintenance_title' => ['Título', 'text'],
            'maintenance_message' => ['Mensagem', 'textarea'],
        ];
    }

    public static function defaults(): array
    {
        return [
            'maintenance_eyebrow' => 'Voltamos em breve',
            'maintenance_title' => 'Estamos a preparar algo especial.',
            'maintenance_message' => 'O nosso site está temporariamente em manutenção. Para reservas ou informações, a nossa equipa continua ao seu dispor.',
        ];
    }

    public function edit(): View
    {
        return view('admin.maintenance', [
            'fields' => static::fields(),
            'defaults' => static::defaults(),
            'active' => setting('maintenance_mode') === '1',
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        Setting::put('maintenance_mode', $request->boolean('is_active') ? '1' : '0', 'system');

        foreach (static::fields() as $key => [$label, $type]) {
            if ($type === 'image' && $request->hasFile("file_{$key}")) {
                Setting::put($key, '/storage/'.$request->file("file_{$key}")->store('cms', 'public'), 'system');

                continue;
            }
            if ($request->has($key)) {
                Setting::put($key, $request->input($key), 'system');
            }
            if ($type !== 'image' && $request->has("en_{$key}")) {
                Setting::putEn($key, $request->input("en_{$key}"));
            }
        }

        return back()->with('status', 'Página de manutenção actualizada.');
    }

    public function toggle(): RedirectResponse
    {
        $on = setting('maintenance_mode') !== '1';
        Setting::put('maintenance_mode', $on ? '1' : '0', 'system');

        return back()->with('status', $on
            ? 'Site em modo de manutenção — visível apenas para si.'
            : 'Site novamente disponível para todos os visitantes.');
    }
}
