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
            if (! Schema::hasColumn('perfumes', 'perfume_type')) {
                $table->enum('perfume_type', ['box', 'fragrance'])->nullable()->after('stock');
            } else {
                $table->enum('perfume_type', ['box', 'fragrance'])->nullable()->change();
            }
        });

        DB::table('perfumes')
            ->whereNotNull('gender')
            ->update(['perfume_type' => 'fragrance']);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perfumes', function (Blueprint $table) {
            if (Schema::hasColumn('perfumes', 'perfume_type')) {
                $table->dropColumn('perfume_type');
            }
        });
    }
};
