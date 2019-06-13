<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stamps', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('stamp_group_id');
            $table->string('image_url');

            $table->primary('id');

            $table->foreign('stamp_group_id')
            ->references('id')->on('stamp_groups')
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
        Schema::dropIfExists('stamps');
        Schema::dropIfExists('chats');
        Schema::dropIfExists('bulletin_boards_comments');
    }
}
