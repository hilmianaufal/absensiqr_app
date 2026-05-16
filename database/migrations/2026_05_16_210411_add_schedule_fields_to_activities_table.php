<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
        public function up(): void
        {
            Schema::table('activities', function (Blueprint $table) {
                $table->string('type')->default('routine')->after('name');
                $table->json('days')->nullable()->after('type');
                $table->date('event_date')->nullable()->after('days');
            });
        }

        public function down(): void
        {
            Schema::table('activities', function (Blueprint $table) {
                $table->dropColumn(['type', 'days', 'event_date']);
            });
        }
};
