<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        /** 帖子标签表 */
        Schema::create('tags', function (Blueprint $table) {
            $table->increments('id');
            $table->tinyInteger('category_id')->default(0)->unsigned()->comment('标签分类id');
            $table->string('name', 100)->default("")->unique()->comment('标签名字');
            $table->timestamps();
        });

        DB::statement("alter table `tags` comment '标签数据表'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tags');
    }
}
