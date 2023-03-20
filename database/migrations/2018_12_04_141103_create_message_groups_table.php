<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMessageGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('message_groups', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('uuid')->unique();
            $table->timestamps();

            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
            $table->integer('deleted_by')->nullable();
        });

        Schema::create('message_group_user', function (Blueprint $table) {
            $table->integer('message_group_id')->unsigned()->index();
            $table->integer('user_id')->unsigned()->index();

            $table->foreign('message_group_id')->references('id')->on('message_groups')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('message_group_user');
        Schema::dropIfExists('message_groups');
    }
}
