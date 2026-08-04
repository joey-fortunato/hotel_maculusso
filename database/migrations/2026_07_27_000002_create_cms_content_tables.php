<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rooms', function (Blueprint $table): void {
            $table->id();
            $table->string('slug')->unique();
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->unsignedInteger('price')->default(0);
            $table->unsignedInteger('price_double')->default(0);
            $table->unsignedTinyInteger('max_guests')->default(2);
            $table->string('detail')->nullable();
            $table->string('guests')->nullable();
            $table->string('size')->nullable();
            $table->string('bed')->nullable();
            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->json('amenities')->nullable();
            $table->json('gallery')->nullable();
            $table->unsignedInteger('sort')->default(0)->index();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('services', function (Blueprint $table): void {
            $table->id();
            $table->string('title');
            $table->text('body')->nullable();
            $table->unsignedInteger('sort')->default(0)->index();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('amenities', function (Blueprint $table): void {
            $table->id();
            $table->string('label');
            $table->string('body')->nullable();
            $table->string('icon')->default('check'); // svg path key
            $table->unsignedInteger('sort')->default(0)->index();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('testimonials', function (Blueprint $table): void {
            $table->id();
            $table->text('quote');
            $table->string('name');
            $table->string('role')->nullable();
            $table->unsignedInteger('sort')->default(0)->index();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('restaurant_items', function (Blueprint $table): void {
            $table->id();
            $table->string('eyebrow')->nullable();
            $table->string('title');
            $table->text('body')->nullable();
            $table->string('image')->nullable();
            $table->unsignedInteger('sort')->default(0)->index();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('gallery_images', function (Blueprint $table): void {
            $table->id();
            $table->string('image');
            $table->string('caption')->nullable();
            $table->boolean('tall')->default(false);
            $table->unsignedInteger('sort')->default(0)->index();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('articles', function (Blueprint $table): void {
            $table->id();
            $table->string('slug')->unique();
            $table->string('title');
            $table->string('excerpt')->nullable();
            $table->string('image')->nullable();
            $table->longText('body')->nullable();
            $table->unsignedInteger('sort')->default(0)->index();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        Schema::create('nav_items', function (Blueprint $table): void {
            $table->id();
            $table->string('label');
            $table->string('route')->nullable();   // named route
            $table->string('pattern')->nullable(); // routeIs() pattern for active state
            $table->unsignedInteger('sort')->default(0)->index();
            $table->boolean('is_published')->default(true);
            $table->timestamps();
        });

        Schema::create('pages', function (Blueprint $table): void {
            $table->id();
            $table->string('key')->unique(); // privacy | terms
            $table->string('eyebrow')->nullable();
            $table->string('title');
            $table->text('intro')->nullable();
            $table->string('image')->nullable();
            $table->json('sections')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        foreach (['pages', 'nav_items', 'articles', 'gallery_images', 'restaurant_items', 'testimonials', 'amenities', 'services', 'rooms'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
