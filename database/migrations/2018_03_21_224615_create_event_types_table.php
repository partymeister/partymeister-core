<?php

use Culpa\Database\Schema\Blueprint;
use Culpa\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

class CreateEventTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('event_types', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('web_color');
            $table->string('slide_color');
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
        Schema::dropIfExists('event_types');
    }
}
