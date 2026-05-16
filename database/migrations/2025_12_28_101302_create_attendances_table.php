<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('attendance_session_id')->constrained()->cascadeOnDelete();
            $table->foreignId('student_id')->constrained()->cascadeOnDelete();

            $table->timestamp('scanned_at');
            $table->enum('status', ['hadir','terlambat'])->default('hadir');

            $table->timestamps();
            $table->unique(['attendance_session_id','student_id']); // anti dobel
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
