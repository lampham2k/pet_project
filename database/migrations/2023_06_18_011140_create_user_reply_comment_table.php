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
        Schema::create('user_reply_comments', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->foreignId('users_comment_product_id')->constrained('user_comment_products')->nullable();
            $table->integer('user_reply_comment_id')->nullable();
            $table->foreignId('user_id')->constrained('users');
            $table->string('comment');
            $table->timestamp('created_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('user_reply_comment');
    }
};
