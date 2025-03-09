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
        Schema::table('favourites', function (Blueprint $table) {
            $table->foreignId('product_id')->nullable()->change();
        });

        // Only add vendor_id if it doesn't exist
        if (!Schema::hasColumn('favourites', 'vendor_id')) {
            Schema::table('favourites', function (Blueprint $table) {
                $table->foreignId('vendor_id')->nullable()->constrained()->onDelete('cascade');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('favourites', function (Blueprint $table) {
            $table->foreignId('product_id')->constrained()->onDelete('cascade')->change();

            // Only if we have foreign key constraint
            if (Schema::hasColumn('favourites', 'vendor_id')) {
                $table->dropForeign(['vendor_id']);
                $table->dropColumn('vendor_id');
            }
        });
    }
};
