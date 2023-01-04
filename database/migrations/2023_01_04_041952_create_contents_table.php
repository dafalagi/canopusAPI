<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->id();
            $table->string('title')->unique();
            $table->longText('intro');
            $table->longText('history');
            $table->enum('category', ['Planet', 'Bintang', 'Rasi Bintang', 'Lainnya di Angkasa']);
            $table->string('coordinate')->nullable();
            $table->string('distance')->nullable();
            $table->enum('event', ['Merkurius', 'Venus', 'Bumi', 'Mars', 'Jupiter', 'Saturnus', 'Uranus', 'Neptunus', 
            'Ceres', 'Eris', 'Pluto', 'Makemake', 'Haumea'])->nullable();
            $table->text('excerpt');
            $table->string('mainpicture')->nullable();
            $table->json('pictures')->nullable();
            $table->string('slug')->unique();
            $table->text('trivia');
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
        Schema::dropIfExists('contents');
    }
};
