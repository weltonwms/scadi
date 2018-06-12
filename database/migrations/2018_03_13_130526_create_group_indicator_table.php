<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGroupIndicatorTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('group_indicator', function (Blueprint $table) {
            $table->integer('indicator_id')->unsigned();
            $table->integer('group_id')->unsigned();

            $table->foreign('indicator_id')->references('id')->on('indicators')->onDelete('cascade');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('group_indicator');
    }

}
