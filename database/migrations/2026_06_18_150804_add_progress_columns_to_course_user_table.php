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
        Schema::table('course_user', function (Blueprint $table) {
            $table->string('working_time')->default('00:00:00');
            $table->boolean('result')->default(false); // false = Tidak, true = Ya
            $table->boolean('is_completed')->default(false); // false = Tidak, true = Ya
            $table->integer('progress')->default(0); // 0-100 percentage
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('course_user', function (Blueprint $table) {
            $table->dropColumn(['working_time', 'result', 'is_completed', 'progress']);
        });
    }
};
