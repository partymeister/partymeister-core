<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('component_visitor_logins', function (Blueprint $table) {
            $table->bigInteger('password_forgotten_page_id')->after('visitor_registration_page_id')->unsigned()->nullable()->index();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('component_visitor_logins', function (Blueprint $table) {
            $table->dropColumn('password_forgotten_page_id');
        });
    }
};
