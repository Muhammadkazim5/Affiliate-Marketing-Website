<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->enum("is_featured", ['Yes', 'No'])->default('No')->nullable()->after('price');
            $table->text("short_description")->nullable()->after('description');
            $table->text("shipping_returns")->nullable()->after('short_description');
            $table->text("related_products")->nullable()->after('shipping_returns');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['is_featured', 'short_description', 'shipping_returns', 'related_products']);
        });
    }
};
