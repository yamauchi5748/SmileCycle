<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersStampsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members_stamps', function (Blueprint $table) {
            $table->uuid('member_id');
            $table->uuid('stamp_group_id');

            $table->primary(['member_id', 'stamp_group_id']);

            $table->foreign('stamp_group_id')
            ->references('id')->on('stamp_groups')
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
        Schema::dropIfExists('members_stamps');
    }
}
