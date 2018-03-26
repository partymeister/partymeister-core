<?php

use Culpa\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Culpa\Facades\Schema;

class CreateVisitorsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('visitors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->unique();
            $table->string('group');
            $table->string('country_iso_3166_1');
            $table->string('email')->nullable()->unique();
            $table->string('password');
            $table->string('api_token')->unique();
            $table->rememberToken();
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
        Schema::dropIfExists('visitors');
    }
}
