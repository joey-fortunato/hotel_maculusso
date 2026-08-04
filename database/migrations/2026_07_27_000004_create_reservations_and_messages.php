<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reservations', function (Blueprint $table): void {
            $table->id();
            $table->string('room_slug')->nullable();
            $table->string('room_name')->nullable();
            $table->date('checkin');
            $table->date('checkout');
            $table->unsignedTinyInteger('guests')->default(1);
            $table->string('name');
            $table->string('email');
            $table->string('phone');
            $table->string('status')->default('new')->index(); // new | confirmed | cancelled
            $table->timestamps();
        });

        Schema::create('messages', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->text('body');
            $table->boolean('is_read')->default(false)->index();
            $table->timestamps();
        });

        Schema::dropIfExists('articles');
    }

    public function down(): void
    {
        Schema::dropIfExists('messages');
        Schema::dropIfExists('reservations');
    }
};
