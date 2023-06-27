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
        Schema::create('users', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->boolean('gender')->default(false);
            $table->date('birthday')->nullable();
            $table->integer('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('description')->nullable();
            $table->smallInteger('customer_role')->comment('CustomerRoleEnum');
            $table->smallInteger('user_role')->comment('CustomerRoleEnum');
            $table->integer('accumulated_points');
            $table->foreignId('collaborator_id')->constrained('collaborators');
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
        Schema::dropIfExists('users');
    }
};
