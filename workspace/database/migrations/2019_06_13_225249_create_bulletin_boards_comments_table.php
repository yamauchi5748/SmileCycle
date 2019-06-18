<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBulletinBoardsCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulletin_boards_comments', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('bulletin_board_id')->nullable();
            $table->uuid('member_id')->nullable();
            $table->text('text')->nullable();
            $table->uuid('stamp_id')->nullable();
            $table->enum('comment_type', ['text', 'stamp']);
            $table->timestamp('created_at');

            $table->primary('id');

            $table->foreign('bulletin_board_id')
            ->references('id')->on('bulletin_boards')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('member_id')
            ->references('id')->on('members')
            ->onUpdate('cascade')
            ->onDelete('set null');
            $table->foreign('stamp_id')
            ->references('id')->on('stamps')
            ->onUpdate('cascade')
            ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('bulletin_boards_comments');
    }
}
