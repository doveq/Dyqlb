<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 帖子数据表
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->default(1)->unsigned()->comment('帖子类型，1商品分享，2折扣推荐，3原创好文');
            $table->tinyInteger('category_id')->default(0)->unsigned()->default(0)->comment('分类id');
            $table->integer('uid')->default(0)->unsigned()->comment('发帖用户id');
            $table->string('title', 100)->default("")->comment('帖子标题');
            $table->string('title_thumb')->default("")->comment('标题图片');
            $table->string('description', 300)->comment('简单描述');
            $table->string('link')->default("")->unique()->comment('产品链接地址');
            $table->decimal('price', 8, 2)->default(0)->comment('产品价格');
            $table->text('body')->nullable()->comment('帖子内容,json');
            $table->string('tags')->default("")->comment('帖子标签');
            $table->integer('pros')->unsigned()->default(0)->comment('顶数量');
            $table->integer('cons')->unsigned()->default(0)->comment('踩数量');
            $table->integer('saves')->unsigned()->default(0)->comment('收藏数量');
            $table->tinyInteger('status')->default(0)->comment('状态，0未审核，10通过，20未通过');
            $table->timestamps();

            $table->engine = 'InnoDB';
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('posts');
    }
}
