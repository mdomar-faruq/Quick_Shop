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
        Schema::table('products', function (Blueprint $table) {
            $table->string('slug')->nullable()->unique()->after('name');
            $table->decimal('old_price', 8, 2)->nullable()->after('price');
            $table->json('gallery')->nullable()->after('image');
            $table->text('description')->nullable()->after('image');
            $table->string('sku')->nullable()->after('id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // This allows you to undo the changes if needed
            $table->dropColumn(['slug', 'old_price', 'gallery', 'description', 'sku']);
        });
    }
};
