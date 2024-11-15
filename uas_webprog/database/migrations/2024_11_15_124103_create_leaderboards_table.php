<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLeaderboardsTable extends Migration
{
    public function up()
    {
        Schema::create('leaderboards', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->integer('score')->default(0);
            $table->time('completion_time')->nullable();
            $table->integer('ranking')->default(0);
            $table->timestamps();

            // Foreign key
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('leaderboards');
    }
}
