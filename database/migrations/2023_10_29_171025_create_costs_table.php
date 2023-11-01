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
        Schema::create('costs', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('item_id')->unsigned();
            $table->integer('metal_cost')->default('0');
            $table->integer('chain_cost')->default('0');
            $table->integer('parts_cost')->default('0');
            $table->integer('stone_cost')->default('0');
            $table->integer('processing_cost')->default('0');
            $table->integer('other_cost')->default('0');
            $table->integer('total_cost')->nullable();
            $table->integer('cost_rate')->nullable();
            $table->string('comment',500)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('costs');
    }
};
