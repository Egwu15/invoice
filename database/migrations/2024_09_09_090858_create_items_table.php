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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->decimal('amount', total: 18, places: 2);
            $table->integer('quantity');
            $table->decimal('tax_rate', total: 5, places: 2)->default(0.00);
            $table->decimal('discount_value', total: 12, places: 2)->default(0.00);
            $table->foreignId('discount_type_id')->constrained('discount_types')->onDelete('cascade');
            $table->foreignId('item_type_id')->constrained('item_types')->onDelete('cascade');
            $table->string('description')->nullable();
            $table->foreignId('business_id')->constrained('businesses')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
