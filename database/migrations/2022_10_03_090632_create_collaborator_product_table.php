<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('collaborator_products', function (Blueprint $table) {
            $table->foreignId('collaborator_id')->constrained('collaborators');
            $table->foreignId('product_id')->constrained('products');
            $table->integer('quantity');
            $table->float('total');
            $table->timestamp('created_at')->nullable();
            $table->primary(array('collaborator_id', 'product_id'));
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('collaborator_product');
    }
};
