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
        Schema::create('collaborators', function (Blueprint $table) {
            $table->id()->unsigned();
            $table->string('name');
            $table->string('email');
            $table->string('password');
            $table->boolean('gender')->default(false);
            $table->date('birthday')->nullable();
            $table->integer('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('description')->nullable();
            $table->smallInteger('role')->comment('CollaboratorRoleEnum');
            $table->integer('accumulated_points')->nullable();
            $table->integer('f0_id')->nullable();
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
        Schema::dropIfExists('collaborators');
    }
};
