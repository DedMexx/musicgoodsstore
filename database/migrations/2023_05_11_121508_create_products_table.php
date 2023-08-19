<?php

use App\Models\Product;
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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191)->unique();
            $table->text('description')->nullable();
            $table->string('image', 191)->unique();
            $table->integer('quantity')->default(0);
            $table->decimal('purchase_price', 32, 2);
            $table->decimal('selling_price', 32, 2);
            $table->string('warranty')->nullable();
            $table->unsignedBigInteger('manufacturer_id');
            $table->foreign('manufacturer_id')
                ->references('id')
                ->on('manufacturers')
                ->onDelete('cascade');
            $table->timestamps();
        });

        Product::makeDefault();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
