<?php

use Culpa\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Culpa\Facades\Schema;

class CreateComponentVisitorLoginsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('component_visitor_logins', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('visitor_registration_page_id')->unsigned()->nullable()->index();
            $table->integer('entries_page_id')->unsigned()->nullable()->index();
            $table->integer('voting_page_id')->unsigned()->nullable()->index();
            $table->integer('comments_page_id')->unsigned()->nullable()->index();
            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('component_visitor_logins');
    }
}
