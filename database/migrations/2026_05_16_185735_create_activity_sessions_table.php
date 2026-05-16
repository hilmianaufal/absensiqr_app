<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activity_sessions', function (Blueprint $table) {
            $table->id();

            $table->foreignId('activity_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->dateTime('started_at');

            $table->dateTime('ended_at')
                ->nullable();

            $table->enum('status', ['live', 'closed'])
                ->default('live');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activity_sessions');
    }
};