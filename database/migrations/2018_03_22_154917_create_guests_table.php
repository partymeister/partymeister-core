<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->id();
            $table->bigInteger('category_id')->unsigned()->index()->nullable();
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

            $table->bigInteger('created_by')->nullable();
            $table->bigInteger('updated_by')->nullable();
            $table->bigInteger('deleted_by')->nullable();

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
