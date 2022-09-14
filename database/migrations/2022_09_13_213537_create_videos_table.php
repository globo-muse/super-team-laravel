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
        Schema::create('videos', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('order_id');
            $table->boolean('is_public')->default(true);
            $table->string('vimeo_id');
            $table->string('hash');
            $table->tinyText('thumb')->nullable();
            $table->tinyText('link_play')->nullable();
            $table->string('status')->default('processing');

            $table->foreign('order_id', 'video_order_order_id')->references('id')->on('orders');
            $table->unique('vimeo_id', 'video_vimeo_id_unique');
            $table->unique('hash', 'video_hash_unique');
            $table->index('is_public', 'video_is_public_status');
            $table->index('status', 'video_index_status');

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
        Schema::dropIfExists('videos');
    }
};
