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
            $table->string('invoice_number', 20)->unique();
            $table->boolean('is_sent')->default(false);
            $table->foreignId('business_id')->constrained('businesses')->onDelete('cascade');
            $table->date('due_date')->nullable();
            $table->decimal('total_amount', 18, 2);
            $table->decimal('total_paid', 18, 2)->nullable();
            $table->decimal('tax_rate', 5, 2)->default(0.00);
            $table->enum('payment_status', ['pending', 'paid', 'unpaid', 'part payment'])->default('unpaid');
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('currency')->required();
            $table->foreignId('discount_id')->nullable()->constrained('discounts')->onDelete('set null');
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
