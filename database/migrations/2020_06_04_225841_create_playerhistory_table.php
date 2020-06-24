<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePlayerhistoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('playerhistory', function (Blueprint $table) {
            $table->integer('playerHistoryId', true);
            $table->integer('playerId');
            $table->integer('matches');
            $table->integer('run');
            $table->integer('highestScore');
            $table->integer('fifties');
            $table->integer('hundreds');
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
        Schema::dropIfExists('playerhistory');
    }
}
