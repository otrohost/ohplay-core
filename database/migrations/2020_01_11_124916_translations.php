<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Translations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $translations = explode(",",config('services.languages.available'));

        Schema::create('translations', function (Blueprint $table) use($translations) {
            $table->id();
            foreach ($translations as $translation)
            {
                $table->string($translation, 500)->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('translations');
    }
}
