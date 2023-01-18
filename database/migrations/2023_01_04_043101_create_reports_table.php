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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('comment_id')->constrained()->onUpdate('cascade')->onDelete('cascade')
                  ->nullable();
            $table->foreignId('discuss_id')->constrained()->onUpdate('cascade')->onDelete('cascade')
                  ->nullable();
            $table->foreignId('content_id')->constrained()->onUpdate('cascade')->onDelete('cascade')
                  ->nullable();
            $table->foreignId('user_id')->constrained()->onUpdate('cascade')->onDelete('cascade');
            $table->json('values')->nullable();
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
        Schema::dropIfExists('reports');
    }
};
