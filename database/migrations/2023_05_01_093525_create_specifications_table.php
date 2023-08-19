<?php

use App\Models\Specification;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('specifications', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191)->unique();
            $table->text('description')->nullable();
            $table->timestamps();
        });
        Specification::makeDefault();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specifications');
    }
};
