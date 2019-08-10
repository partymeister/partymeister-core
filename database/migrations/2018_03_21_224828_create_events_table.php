<?php

use Culpa\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Culpa\Facades\Schema;

class CreateEventsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('schedule_id')->unsigned()->index();
            $table->integer('event_type_id')->unsigned()->index()->nullable();
            $table->string('name');
            $table->datetime('starts_at')->nullable();
            $table->datetime('ends_at')->nullable();
            $table->boolean('is_visible');
            $table->boolean('is_organizer_only');
            $table->integer('notify_minutes');
            $table->string('link');
            $table->integer('sort_position');
            $table->timestamps();

            $table->createdBy();
            $table->updatedBy();
            $table->deletedBy(true);

            $table->foreign('schedule_id')->references('id')->on('schedules')->onDelete('cascade');
            $table->foreign('event_type_id')->references('id')->on('event_types')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
