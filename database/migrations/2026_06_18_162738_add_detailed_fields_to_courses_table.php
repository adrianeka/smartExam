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
            $table->string('department')->nullable();
            $table->string('department_url')->nullable();
            $table->string('template_course_id')->nullable();
            $table->boolean('is_demo_content')->default(false);
            $table->string('access_type')->nullable(); // public, private, dll
            $table->boolean('subscription_allowed')->default(true);
            $table->boolean('unsubscription_allowed')->default(false);
            $table->integer('storage_limit_mb')->nullable();
            $table->boolean('is_special_course')->default(false);
            $table->text('tags')->nullable();
            $table->string('video_url')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('courses', function (Blueprint $table) {
            $table->dropColumn([
                'department',
                'department_url',
                'template_course_id',
                'is_demo_content',
                'access_type',
                'subscription_allowed',
                'unsubscription_allowed',
                'storage_limit_mb',
                'is_special_course',
                'tags',
                'video_url'
            ]);
        });
    }
};
