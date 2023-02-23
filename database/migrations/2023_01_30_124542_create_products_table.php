<?php

use App\Models\Product;
use Domain\Catalog\Models\Brand;
use Domain\Catalog\Models\Category;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignIdFor(Brand::class)->constrained();

            $table->string('slug')->unique();
            $table->string('title');
            $table->string('image')->nullable();
            $table->unsignedInteger('price')->default(0);
            $table->string('text')->nullable();

            $table->boolean('is_on_homepage')->default(false);
            $table->unsignedTinyInteger('order')->default(100);

            $table->fullText(['title', 'text']);

            $table->timestamps();
        });

        Schema::create('category_product', function (Blueprint $table) {
            $table->foreignIdFor(Category::class)->constrained();
            $table->foreignIdFor(Product::class)->constrained();

            $table->primary(['category_id', 'product_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('products');
    }
};
