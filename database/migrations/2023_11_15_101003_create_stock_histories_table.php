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
        Schema::create('stock_histories', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['in', 'out'])->default('out');
            $table->integer('item_id');
            $table->integer('category_id');
            $table->integer('unit_id');
            $table->integer('stock_type_id');
            $table->integer('location_id');
            $table->integer('branch_id');
            $table->integer('foreign_id');
            $table->integer('qty')->default(0);
            $table->json('detail');
            $table->integer('user_id');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_histories');
    }
};
