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
        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'customer_role')) {
                $table->smallInteger('customer_role')->nullable()->change();
            }
            if (Schema::hasColumn('users', 'user_role')) {
                $table->smallInteger('user_role')->nullable()->change();
            }
            if (Schema::hasColumn('users', 'accumulated_points')) {
                $table->integer('accumulated_points')->nullable()->change();
            }
            if (Schema::hasColumn('users', 'collaborator_id')) {
                $table->foreignId('collaborator_id')->nullable()->change();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
    }
};
