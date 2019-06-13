<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBulletinBoardsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulletin_boards', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('post_member_id')->nullable();
            $table->string('title', 32);
            $table->enum('template', ['1', '2', '3']);
            $table->timestamp('created_at');

            $table->primary('id');

            $table->foreign('post_member_id')
            ->references('id')->on('members')
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
        Schema::dropIfExists('bulletin_boards');
    }
}
