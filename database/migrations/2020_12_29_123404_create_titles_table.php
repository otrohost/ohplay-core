<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTitlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('titles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('title');
            $table->foreign('title')->references('id')->on('translations');
            $table->unsignedBigInteger('sinopsis');
            $table->foreign('sinopsis')->references('id')->on('translations');
            $table->integer('tmdb_id');
            $table->integer('year')->nullable();
            $table->string('cover_horizontal', 200)->nullable();
            $table->string('cover_vertical', 200)->nullable();
            $table->string('type', 10);
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
        Schema::dropIfExists('titles');
    }
}
