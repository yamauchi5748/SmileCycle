<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBulletinBoardsContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulletin_boards_contents', function (Blueprint $table) {
            $table->uuid('bulletin_board_id');
            $table->integer('placement_id');
            $table->text('text')->nullable();
            $table->string('image_url')->nullable();
            $table->enum('content_type', ['text', 'image']);

            $table->primary('bulletin_board_id');

            $table->foreign('bulletin_board_id')
            ->references('id')->on('bulletin_boards')
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
        Schema::dropIfExists('bulletin_boards_contents');
    }
}
