<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function(Blueprint $table) {
            // id BIGINT UNSIGNED AUTO INCRENENT PRIMARY KEY
            //$table->bigInteger('id')->unsigned()->autoIncrement()->primary();
            //$table->unsignedBigInteger('id')->autoIncrement()->primary();
            //$table->bigIncrements('id');
            $table->id();

            // name VARCHAR(255)
            $table->string('name');
            $table->string('slug')->unique();

            // created_at TIMESTAMP, updated_at TIMESTAMP
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
        Schema::dropIfExists('tags');
    }
}
