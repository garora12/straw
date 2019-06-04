<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('userName');
            $table->string('universityEmail');
            $table->string('password');
            $table->text('imageLink')->nullable();
            $table->enum('gender', ['MALE', 'FEMALE', 'NEUTRAL', 'OTHER'])->default('MALE');
            $table->integer('studyingYear');
            $table->integer('branchId');
            $table->enum('status', ['OPEN', 'CLOSE', 'DELETED', 'BLOCKED'])->default('OPEN');
            $table->timestamps();
            
            // $table->unique([DB::raw('userName(191)')]);
            // $table->unique([DB::raw('universityEmail(191)')]);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
