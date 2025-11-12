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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            // Relationship
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            // Invoice details
            $table->string('invoice_number')->unique();
            $table->date('date')->nullable();

            // Sender & recipient
            $table->string('from_name');
            $table->string('from_email');
            $table->string('to_name');
            $table->string('to_email');

            // Optional company logo
            $table->string('logo')->nullable();

            // Totals and rates
            $table->decimal('tax_rate', 8, 2)->default(0);
            $table->decimal('discount_rate', 8, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            $table->decimal('discount_amount', 10, 2)->default(0);
            $table->decimal('total_amount', 10, 2)->default(0);

            // Items (we’ll store them as JSON)
            $table->json('items');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
