<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('events', function (Blueprint $table) {
            $table->id('id');
            $table->unsignedBigInteger('event_id')->unique()->comment('コンパスのサイト上のイベントID');
            $table->date('date')->index()->comment('日程');
            $table->time('begin_time')->comment('開始時間');
            $table->time('end_time')->comment('終了時間');
            $table->string('url')->comment('url');
            $table->string('title')->index()->comment('タイトル');
            $table->string('group')->index()->nullable()->comment('グループ名');
            $table->string('owner')->index()->comment('管理者名');
            $table->string('address')->index()->nullable()->comment('住所');
            $table->integer('accepted')->index()->comment('参加者人数');
            $table->integer('limit')->nullable()->comment('定員人数');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('events');
    }
}
