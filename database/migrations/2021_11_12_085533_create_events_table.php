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
            $table->id();
            $table->integer('event_id')->unique()->comment('イベントID');
            $table->string('date')->comment('日程');
            $table->string('begin_time')->comment('開始時間');
            $table->string('end_time')->comment('終了時間');
            $table->string('url')->comment('url');
            $table->string('title')->comment('タイトル');
            $table->string('group')->nullable()->comment('グループ名');
            $table->string('owner')->comment('管理者名');
            $table->string('address')->nullable()->comment('住所');
            $table->integer('accepted')->comment('参加者人数');
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
