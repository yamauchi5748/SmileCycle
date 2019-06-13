<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('members', function (Blueprint $table) {
            $table->uuid('id');
            $table->string('name', 64)->unique();
            $table->string('ruby', 128);
            $table->string('post', 32);
            $table->string('mail', 256)->unique();
            $table->string('api_token');
            $table->string('password');
            $table->string('profile_text', 64);
            $table->string('profile_image_url');
            $table->uuid('company_id')->nullable();
            $table->enum('department_name', ['愛媛', '鎌倉', '大阪', '東京']);
            $table->boolean('is_notification');
            $table->enum('notification_interval', ['0.5h', '1h', '3h', '5h']);
            $table->boolean('is_admin');

            $table->primary('id');

            $table->foreign('company_id')
            ->references('id')->on('companies')
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
        Schema::dropIfExists('members');
        Schema::dropIfExists('members_stamps');
        Schema::dropIfExists('chat_rooms');
        Schema::dropIfExists('chats');
        Schema::dropIfExists('chat_rooms_members');
        Schema::dropIfExists('bulletin_boards');
    }
}
