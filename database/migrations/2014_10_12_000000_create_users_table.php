<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('uid')->unique();
            $table->string('name', 20);
            $table->string('surname', 30);
            $table->string('image', 20)->nullable();
            $table->date('birthdate');
            $table->string('phone', 20);
            $table->string('password', 60);
            $table->boolean('type');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
