<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('settings', function (Blueprint $table): void {
            $table->longText('value_en')->nullable()->after('value');
        });

        Schema::table('rooms', function (Blueprint $table): void {
            $table->string('name_en')->nullable();
            $table->string('tagline_en')->nullable();
            $table->text('description_en')->nullable();
            $table->string('bed_en')->nullable();
            $table->json('amenities_en')->nullable();
        });

        Schema::table('services', function (Blueprint $table): void {
            $table->string('title_en')->nullable();
            $table->text('body_en')->nullable();
        });

        Schema::table('amenities', function (Blueprint $table): void {
            $table->string('label_en')->nullable();
            $table->string('body_en')->nullable();
        });

        Schema::table('testimonials', function (Blueprint $table): void {
            $table->text('quote_en')->nullable();
            $table->string('role_en')->nullable();
        });

        Schema::table('restaurant_items', function (Blueprint $table): void {
            $table->string('eyebrow_en')->nullable();
            $table->string('title_en')->nullable();
            $table->text('body_en')->nullable();
        });

        Schema::table('gallery_images', function (Blueprint $table): void {
            $table->string('caption_en')->nullable();
        });

        Schema::table('nav_items', function (Blueprint $table): void {
            $table->string('label_en')->nullable();
        });

        Schema::table('pages', function (Blueprint $table): void {
            $table->string('title_en')->nullable();
            $table->text('intro_en')->nullable();
            $table->json('sections_en')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('settings', fn (Blueprint $t) => $t->dropColumn('value_en'));
        Schema::table('rooms', fn (Blueprint $t) => $t->dropColumn(['name_en', 'tagline_en', 'description_en', 'bed_en', 'amenities_en']));
        Schema::table('services', fn (Blueprint $t) => $t->dropColumn(['title_en', 'body_en']));
        Schema::table('amenities', fn (Blueprint $t) => $t->dropColumn(['label_en', 'body_en']));
        Schema::table('testimonials', fn (Blueprint $t) => $t->dropColumn(['quote_en', 'role_en']));
        Schema::table('restaurant_items', fn (Blueprint $t) => $t->dropColumn(['eyebrow_en', 'title_en', 'body_en']));
        Schema::table('gallery_images', fn (Blueprint $t) => $t->dropColumn('caption_en'));
        Schema::table('nav_items', fn (Blueprint $t) => $t->dropColumn('label_en'));
        Schema::table('pages', fn (Blueprint $t) => $t->dropColumn(['title_en', 'intro_en', 'sections_en']));
    }
};
