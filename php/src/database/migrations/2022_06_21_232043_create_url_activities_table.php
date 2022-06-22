<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUrlActivitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('url_activities', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('url_id');
            $table->timestamps();

            $table->foreign('url_id')->references('id')->on('urls');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('url_activities');
    }
}
