<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id(); // Primary key
            $table->string('title');
            $table->text('description');
            $table->date('date');
            $table->string('location');
            $table->integer('max_participants')->default(0);
            $table->unsignedBigInteger('created_by'); // Admin ID
            $table->timestamps();

            // Foreign key to users
            $table->foreign('created_by')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('events');
    }
}
