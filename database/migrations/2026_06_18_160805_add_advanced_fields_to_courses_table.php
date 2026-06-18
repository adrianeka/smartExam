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
        Schema::table('courses', function (Blueprint $table) {
            $table->string('language')->nullable()->after('description');
            $table->string('category')->nullable()->after('language');
            $table->boolean('is_registered_allowed')->default(true)->after('category');
            $table->boolean('is_unregistered_allowed')->default(false)->after('is_registered_allowed');
            $table->timestamp('last_accessed_at')->nullable()->after('is_unregistered_allowed');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn([
                'language',
                'category',
                'is_registered_allowed',
                'is_unregistered_allowed',
                'last_accessed_at',
            ]);
        });
    }
};
