<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_sender')->unsigned();
            $table->bigInteger('user_addressee')->unsigned();
            $table->text('message');
            $table->enum('status_message', ['sent','received','read'])->default('sent');
            $table->timestamps();
            $table->softDeletes($column = 'deleted_at', $precision = 0);
            //foreign keys
            $table->foreign('user_sender')->references('id')->on('users');
            $table->foreign('user_addressee')->references('id')->on('users');

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
};
