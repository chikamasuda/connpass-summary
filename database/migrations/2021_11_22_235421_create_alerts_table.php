<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlertsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alerts', function (Blueprint $table) {
            $table->id('alert_id');
            $table->unsignedBigInteger('event_id')->unique()->index()->constrained()->onDelete('cascade')->comment('イベントテーブルID');
            $table->integer('number')->comment('人数');
            $table->integer('diff')->index()->comment('前日との差分');
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
        Schema::dropIfExists('alerts');
    }
}
