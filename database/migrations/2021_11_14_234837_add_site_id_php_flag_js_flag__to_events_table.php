<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSiteIdPhpFlagJsFlagToEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->integer('site_id')->comment('サイトID');
            $table->integer('php_flag')->nullable()->comment('PHPフラグ');
            $table->integer('js_flag')->nullable()->comment('JSフラグ');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('site_id');
            $table->dropColumn('php_flag');
            $table->dropColumn('js_flag');
        });
    }
}
