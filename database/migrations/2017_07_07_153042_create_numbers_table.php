<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('numbers', function (Blueprint $table) {
            $table->increments('id');

            // Numura formāts
            $table->integer('number_format_id');
            // Cipars pēc kārtas
            $table->integer('counter');
            // Formatēts numurs
            $table->string('number');
            // Cik mēģinājumi bija vajadzīgi, lai uzģenerētu unikālu numuru
            $table->integer('generate_tries');

            $table->timestamps();

            $table->unique(['number_format_id', 'number'], 'number');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('numbers');
    }
};
