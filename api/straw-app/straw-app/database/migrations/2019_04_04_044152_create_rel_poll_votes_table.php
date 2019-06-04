<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRelPollVotesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rel_poll_votes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('pollId');
            $table->bigInteger('userId');
            $table->enum('vote', ['YES', 'NO'])->default('YES');
            $table->enum('status', ['OPEN', 'CLOSE', 'DELETED'])->default('OPEN');
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
        Schema::dropIfExists('rel_poll_votes');
    }
}
