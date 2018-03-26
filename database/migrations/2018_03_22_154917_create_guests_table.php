<?php

use Culpa\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Culpa\Facades\Schema;

class CreateGuestsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('category_id')->unsigned()->index()->nullable();
            $table->string('name');
            $table->string('handle');
            $table->string('email');
            $table->string('company');
            $table->string('country');
            $table->string('ticket_code');
            $table->string('ticket_type');
            $table->string('ticket_order_number');
            $table->boolean('has_badge');
            $table->boolean('has_arrived');
            $table->boolean('ticket_code_scanned');
            $table->text('comment');
            $table->datetime('arrived_at')->nullable();
            $table->timestamps();

            $table->createdBy();
            $table->updatedBy();
            $table->deletedBy(true);

            $table->foreign('category_id')->references('id')->on('categories')->onDelete('set null');
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guests');
    }
}
