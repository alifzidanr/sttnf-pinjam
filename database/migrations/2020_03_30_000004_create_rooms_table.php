<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRoomsTable extends Migration
{
    public function up()
    {
        Schema::create('rooms', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('capacity')->nullable();
            $table->longText('description')->nullable();
            $table->string('location');
            $table->string('resp');
            $table->string('resp_no');    
            $table->timestamps();
            $table->softDeletes();
        });

    }
}
