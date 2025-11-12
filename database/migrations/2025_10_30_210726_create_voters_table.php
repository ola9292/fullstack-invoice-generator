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
        Schema::create('voters', function (Blueprint $table) {
            $table->id();
            // The poll being voted on
            $table->foreignId('poll_id')
                ->constrained()
                ->cascadeOnDelete();

            // The user who voted
            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            // The option they selected
            $table->foreignId('option_id')
                ->constrained('polls')
                ->cascadeOnDelete();

            // Ensure a user can only vote once per poll
            $table->unique(['poll_id', 'user_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('voters');
    }
};
