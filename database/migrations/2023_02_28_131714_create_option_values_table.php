<?php

use Domain\Product\Models\Option;
use Domain\Product\Models\OptionValue;
use Domain\Product\Models\Product;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('option_values', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Option::class);

            $table->string('title');

            $table->timestamps();
        });

        Schema::create('option_value_product', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(OptionValue::class);
            $table->foreignIdFor(Product::class);
            $table->unique(['option_value_id', 'product_id']); // primary

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('option_values');
    }
};
