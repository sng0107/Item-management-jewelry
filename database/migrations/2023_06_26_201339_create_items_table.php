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
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('type_id')->unsigned();
            $table->bigInteger('supplier_id')->unsigned();
            $table->string('item_code', 20)->uniqid()->index();
            $table->string('item_name', 50)->index();
            $table->integer('retail_price')->default('0');
            $table->integer('stock')->default('0');
            $table->text('img')->nullable();
            $table->string('spec', 100)->nullable();
            $table->string('material',100)->nullable();
            $table->string('sales_period',30);
            $table->string('comment', 500)->nullable();
             $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
