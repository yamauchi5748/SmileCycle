<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformationsContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informations_contents', function (Blueprint $table) {
            $table->uuid('information_id');
            $table->integer('placement_id');
            $table->text('text')->nullable();
            $table->string('image_url')->nullable();
            $table->enum('content_type', ['text', 'image']);

            $table->primary(['information_id', 'placement_id']);

            $table->foreign('information_id')
            ->references('id')->on('informations')
            ->onUpdate('cascade')
            ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('informations_contents');
    }
}
