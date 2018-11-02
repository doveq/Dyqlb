<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFavoriteTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('favorite', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('uid')->default(0)->unsigned()->comment('用户id');
            $table->integer('posts_id')->default(0)->unsigned()->comment('收藏帖子id');
            $table->timestamps();
            $table->index('uid');
        });

        DB::statement("alter table `favorite` comment '用户收藏数据表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('favorite');
    }
}
