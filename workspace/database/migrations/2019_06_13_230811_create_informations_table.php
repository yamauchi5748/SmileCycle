<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInformationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('informations', function (Blueprint $table) {
            $table->uuid('id');
            $table->uuid('post_member_id')->nullable();
            $table->string('title', 32);
            $table->enum('template', ['1', '2', '3']);
            $table->timestamp('deadline_at');
            $table->timestamp('created_at')->useCurrent();

            $table->primary('id');

            $table->foreign('post_member_id')
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
        Schema::dropIfExists('informations_contents');
        Schema::dropIfExists('informations');
    }
}
