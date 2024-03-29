<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

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
            $table->id();
            $table->bigInteger('visitor_registration_page_id')->unsigned()->nullable()->index();
            $table->bigInteger('entries_page_id')->unsigned()->nullable()->index();
            $table->bigInteger('voting_page_id')->unsigned()->nullable()->index();
            $table->bigInteger('comments_page_id')->unsigned()->nullable()->index();
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
