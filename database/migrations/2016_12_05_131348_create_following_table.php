<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFollowingTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('following', function(Blueprint $table) {
           $table->increments('id');
            $table->integer('follower_id');
            $table->integer('following_id');
            $table->timestamps();

            $table->foreign('follower_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
            $table->foreign('following_id')->references('id')->on('users')->onUpdate('cascade')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('following');
    }
}
