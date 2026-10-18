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
        Schema::create('featured_products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('perfume_id')
                ->nullable()
                ->unique()
                ->constrained()
                ->cascadeOnDelete();
            $table->foreignId('sunglasses_id')
                ->nullable()
                ->unique()
                ->constrained()
                ->cascadeOnDelete();
            $table->unsignedInteger('position')->default(0);
            $table->timestamps();
        });

        if (DB::getDriverName() === 'mysql') {
            DB::statement(
                'ALTER TABLE featured_products ADD CONSTRAINT featured_products_exactly_one_product '
                    .'CHECK ((perfume_id IS NOT NULL AND sunglasses_id IS NULL) '
                    .'OR (perfume_id IS NULL AND sunglasses_id IS NOT NULL))',
            );
        } elseif (DB::getDriverName() === 'sqlite') {
            DB::statement(
                "CREATE TRIGGER featured_products_valid_reference_insert
                BEFORE INSERT ON featured_products
                FOR EACH ROW
                WHEN NOT (
                    (NEW.perfume_id IS NOT NULL AND NEW.sunglasses_id IS NULL)
                    OR (NEW.perfume_id IS NULL AND NEW.sunglasses_id IS NOT NULL)
                )
                BEGIN
                    SELECT RAISE(ABORT, 'featured_products_requires_exactly_one_product');
                END",
            );
            DB::statement(
                "CREATE TRIGGER featured_products_valid_reference_update
                BEFORE UPDATE ON featured_products
                FOR EACH ROW
                WHEN NOT (
                    (NEW.perfume_id IS NOT NULL AND NEW.sunglasses_id IS NULL)
                    OR (NEW.perfume_id IS NULL AND NEW.sunglasses_id IS NOT NULL)
                )
                BEGIN
                    SELECT RAISE(ABORT, 'featured_products_requires_exactly_one_product');
                END",
            );
        } else {
            throw new RuntimeException('Featured products are only supported on MySQL and SQLite databases.');
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (DB::getDriverName() === 'sqlite') {
            DB::statement('DROP TRIGGER IF EXISTS featured_products_valid_reference_insert');
            DB::statement('DROP TRIGGER IF EXISTS featured_products_valid_reference_update');
        }

        Schema::dropIfExists('featured_products');
    }
};
