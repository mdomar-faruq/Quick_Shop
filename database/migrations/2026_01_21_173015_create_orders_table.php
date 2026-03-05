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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('customer_name')->nullable();
            $table->string('mobile');
            $table->text('address')->nullable(); // Changed to text for longer addresses
            $table->json('cart_details');

            // Financial Columns
            $table->decimal('subtotal', 10, 2)->default(0); // Price of items only
            $table->decimal('delivery_charge', 10, 2)->default(0); // 60 or 120
            $table->decimal('total_amount', 10, 2); // subtotal + delivery_charge

            // Logistics
            $table->string('delivery_area')->nullable(); // e.g., 'inside_dhaka'
            $table->string('status')->default('pending'); // pending, processing, shipped, completed, cancelled

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
