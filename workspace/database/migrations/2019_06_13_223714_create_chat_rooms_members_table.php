<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatRoomsMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chat_rooms_members', function (Blueprint $table) {
            $table->uuid('chat_room_id');
            $table->uuid('member_id');
            $table->timestamp('chekced_at');

            $table->primary(['chat_room_id', 'member_id']);

            $table->foreign('chat_room_id')
            ->references('id')->on('chat_rooms')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('member_id')
            ->references('id')->on('members')
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
        Schema::dropIfExists('chat_rooms_members');
    }
}
