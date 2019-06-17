<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformationsAttendsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informations_attends', function (Blueprint $table) {
            $table->uuid('information_id');
            $table->uuid('member_id');
            $table->enum('attend_status', ['unselected','attendance','absent']);

            $table->primary(['information_id', 'member_id']);

            $table->foreign('information_id')
            ->references('id')->on('informations')
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
        Schema::dropIfExists('informations_attends');
    }
}
