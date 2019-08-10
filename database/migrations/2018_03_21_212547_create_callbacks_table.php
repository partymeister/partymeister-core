<?php

use Culpa\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Culpa\Facades\Schema;

class CreateCallbacksTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('callbacks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('action');
            $table->json('payload');
            $table->string('title');
            $table->string('body');
            $table->string('link');
            $table->string('destination');
            $table->string('hash')->unique();
            $table->boolean('is_timed');
            $table->boolean('has_fired');
            $table->dateTime('fired_at')->nullable();
            $table->dateTime('embargo_until')->nullable();
            $table->timestamps();

            $table->createdBy();
            $table->updatedBy();
            $table->deletedBy(true);
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('callbacks');
    }
}
