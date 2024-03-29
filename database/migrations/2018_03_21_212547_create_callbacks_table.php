<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->id();
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

            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();
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
