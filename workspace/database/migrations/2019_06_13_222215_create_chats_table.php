<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('chat_room_id')->nullable();
            $table->uuid('send_member_id')->nullable();
            $table->text('message')->nullable();
            $table->uuid('stamp_id')->nullable();
            $table->string('content_url')->nullable();
            $table->enum('content_type', ['text','stamp','image','video']);
            $table->boolean('is_hurry');
            $table->timestamp('created_at');

            $table->primary('id');

            $table->foreign('chat_room_id')
            ->references('id')->on('chat_rooms')
            ->onUpdate('cascade')
            ->onDelete('cascade');
            $table->foreign('send_member_id')
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
        Schema::dropIfExists('chats');
    }
}
