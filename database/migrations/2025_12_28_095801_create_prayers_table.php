<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('prayers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Subuh, Dzuhur, Ashar, Maghrib, Isya
            $table->unsignedTinyInteger('order')->default(1);
            $table->time('start_time'); // buka scan
            $table->time('end_time');   // tutup scan
            $table->unsignedSmallInteger('late_minutes')->default(10); // toleransi telat
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prayers');
    }
};
