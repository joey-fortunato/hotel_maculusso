<?php

use App\Models\NavItem;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /** Backfill English menu labels for existing installs (only where still empty). */
    public function up(): void
    {
        $map = [
            'home' => 'Home',
            'rooms.index' => 'Rooms',
            'services.index' => 'Services',
            'restaurant' => 'Restaurant',
            'gallery' => 'Gallery',
            'about' => 'About',
            'contact' => 'Contact',
        ];

        foreach ($map as $route => $labelEn) {
            NavItem::where('route', $route)
                ->whereNull('label_en')
                ->update(['label_en' => $labelEn]);
        }
    }

    public function down(): void
    {
        NavItem::query()->update(['label_en' => null]);
    }
};
