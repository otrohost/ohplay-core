<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTitlesPeopleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('titles_people', function (Blueprint $table) {
            $table->id();
            $table->foreignId('person_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->foreignId('title_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->string('role');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('titles_people');
    }
}
