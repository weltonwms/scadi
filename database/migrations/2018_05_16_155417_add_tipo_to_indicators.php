<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTipoToIndicators extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::table('indicators', function($table) {
            $table->tinyInteger('tipo')->nullable()->after('id');
            $table->string('denominador_sigla')->nullable()->change();
            $table->string('denominador_name')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('indicators', function($table) {
            $table->dropColumn('tipo');
            $table->string('denominador_sigla')->change();
            $table->string('denominador_name')->change();
        });
    }

}
