<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** 帖子数据表 */
        Schema::create('posts', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('type')->default(1)->unsigned()->comment('帖子类型，1商品分享，2折扣推荐，3原创好文');
            $table->string('tags', 300)->default("")->comment('所属标签,逗号分割');
            $table->integer('uid')->default(0)->unsigned()->comment('发帖用户id');
            $table->string('title', 100)->default("")->comment('帖子标题');
            $table->string('title_thumb')->default("")->comment('标题图片');
            $table->string('description', 500)->comment('简单描述');
            // tx云mysql版本不支持长varchar数据索引。用md5比对
            //$table->string('link')->default("")->unique()->comment('产品链接地址');
            $table->string('link', 500)->default("")->comment('产品链接地址');
            $table->char('link_md5', 32)->unique()->default("")->comment('产品链接md5,方便比对');
            $table->decimal('price', 8, 2)->default(0)->comment('产品价格');
            $table->text('body')->nullable()->comment('帖子内容,json');
            $table->integer('pros')->unsigned()->default(0)->comment('顶数量');
            $table->integer('cons')->unsigned()->default(0)->comment('踩数量');
            $table->integer('saves')->unsigned()->default(0)->comment('收藏数量');
            $table->integer('pv')->unsigned()->default(0)->comment('浏览量');
            $table->tinyInteger('status')->default(0)->comment('状态，0未审核，10通过，20未通过');
            $table->timestamps();

            $table->engine = 'InnoDB';
        });

        DB::statement("alter table `posts` comment '帖子数据表'");
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
