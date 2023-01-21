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
            $table->string('category');
            $table->string('coordinate')->nullable();
            $table->string('distance')->nullable();
            $table->string('event')->nullable();
            $table->text('excerpt');
            $table->string('mainpicture')->nullable();
            $table->json('pictures')->nullable();
            $table->string('slug')->unique();
            $table->text('trivia')->nullable();
            $table->string('videoId')->nullable();
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
