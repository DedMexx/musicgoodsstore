<?php

use App\Models\SpecificationProduct;
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
        Schema::create('specification_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('specification_id');
            $table->unsignedBigInteger('product_id');
            $table->foreign('specification_id')
                ->references('id')
                ->on('specifications')
                ->onDelete('cascade');
            $table->foreign('product_id')
                ->references('id')
                ->on('products')
                ->onDelete('cascade');
            $table->string('value');
            $table->timestamps();

            $table->unique(['product_id', 'specification_id']);
        });
        SpecificationProduct::makeDefault();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specification_products');
    }
};
