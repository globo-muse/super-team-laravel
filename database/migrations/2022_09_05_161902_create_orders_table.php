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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('responder_id');

            $table->string('name', 100);
            $table->string('email', 100);
            $table->string('occasion', 100)->nullable();
            $table->text('instructions');
            $table->string('status', 40)->default('open');

            $table->foreign('user_id', 'order_users_user_id')->references('id')->on('users');
            $table->foreign('responder_id', 'order_users_responder_id')->references('id')->on('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('orders');
    }
};
