<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('nis')->unique();
            $table->string('name');
            $table->string('kelas')->nullable();   // contoh: 7A, 8B
            $table->string('kamar')->nullable();   // contoh: Umar, Ali
            $table->boolean('is_active')->default(true);
            $table->string('qr_token')->unique();  // token QR permanen
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

