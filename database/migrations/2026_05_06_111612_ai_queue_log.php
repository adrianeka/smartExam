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
              Schema::create('ai_queue_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('queue_id')->constrained('queues')->onDelete('cascade');
            $table->integer('attempt')->default(1);
            $table->enum('status', ['pending', 'finish', 'failed'])->default('pending');
            $table->text('ai_response')->nullable();
            $table->integer('score')->nullable();
            $table->text('feedback')->nullable();
            $table->integer('confidence')->nullable();
            $table->text('error_message')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('ai_queue_logs');
    }

};
