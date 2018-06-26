<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHierarquiaToIndicatorsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('indicators', function($table) {
            $table->integer('level')->nullable()->after('index_id');
            $table->integer('parent_id')->nullable()->after('index_id');
            $table->float('peso')->default(1)->after('index_id');
            $table->string('subtitulo')->nullable()->after('sigla');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('indicators', function($table) {
            $table->dropColumn('level');
            $table->dropColumn('parent_id');
            $table->dropColumn('peso');
            $table->dropColumn('subtitulo');
        });
    }

}
