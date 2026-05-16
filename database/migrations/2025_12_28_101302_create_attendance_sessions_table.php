<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attendance_sessions', function (Blueprint $table) {
            $table->id();
            $table->date('date');
            $table->foreignId('prayer_id')->constrained()->cascadeOnDelete();

            // optional: status sesi
            $table->enum('status', ['live','closed'])->default('live');

            $table->timestamps();
            $table->unique(['date','prayer_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendance_sessions');
    }
};

