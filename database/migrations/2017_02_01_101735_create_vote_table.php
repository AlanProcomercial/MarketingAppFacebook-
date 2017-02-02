<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('votes', function (Blueprint $table) {
            $table->integer('contest_id')->unsigned();
            $table->integer('contestant_id')->unsigned();
            $table->string('voter_ip');
            $table->timestamps();

            $table->foreign('contest_id')->references('id')->on('contests')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->foreign('contestant_id')->references('id')->on('contestants')
                ->onUpdate('cascade')->onDelete('cascade');

            $table->primary(['contest_id', 'contestant_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('votes');
    }
}
