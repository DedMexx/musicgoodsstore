<?php

use App\Models\Supplier;
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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191)->unique();
            $table->string('email', 191)->unique();
            $table->string('phone', 191)->unique();
            $table->string('country');
            $table->string('region');
            $table->string('city');
            $table->string('street');
            $table->string('house');
            $table->string('post_index');
            $table->string('last_name');
            $table->string('first_name');
            $table->string('third_name')->nullable(true);
            $table->timestamps();
        });
        Supplier::makeDefault();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
