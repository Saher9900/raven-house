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
        Schema::create('perfumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perfumes_category_id')->nullable()->constrained('perfumes_categories')->onDelete('cascade');
            $table->string('name');
            $table->decimal('price', 10, 2);
            $table->string('brand')->nullable();
            $table->text('description')->nullable();
            $table->decimal('sale', 10, 2)->nullable();
            $table->integer('stock')->default(0);
            $table->enum('gender', ['male', 'female']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('perfumes');
    }
};
