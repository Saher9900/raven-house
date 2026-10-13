<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('perfumes', function (Blueprint $table) {
            $table->enum('gender', ['male', 'female', 'men', 'women', 'men & women'])->nullable()->change();
        });

        Schema::table('sunglasses', function (Blueprint $table) {
            $table->enum('gender', ['male', 'female', 'men', 'women', 'men & women'])->nullable()->change();
        });

        DB::table('perfumes')->update(['gender' => null]);
        DB::table('sunglasses')->update(['gender' => null]);

        Schema::table('perfumes', function (Blueprint $table) {
            $table->enum('gender', ['men', 'women', 'men & women'])->nullable()->change();
        });

        Schema::table('sunglasses', function (Blueprint $table) {
            $table->enum('gender', ['men', 'women', 'men & women'])->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('perfumes')->update(['gender' => null]);
        DB::table('sunglasses')->update(['gender' => null]);

        Schema::table('perfumes', function (Blueprint $table) {
            $table->enum('gender', ['male', 'female'])->nullable()->change();
        });

        Schema::table('sunglasses', function (Blueprint $table) {
            $table->enum('gender', ['male', 'female'])->nullable()->change();
        });
    }
};
