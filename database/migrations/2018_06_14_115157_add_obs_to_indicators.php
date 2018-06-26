<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddObsToIndicators extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('indicators', function (Blueprint $table) {
             $table->string('numerador_obs_padrao')->nullable()->after('numerador_valor_padrao');
             $table->string('denominador_obs_padrao')->nullable()->after('denominador_valor_padrao');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('indicators', function (Blueprint $table) {
            $table->dropColumn('numerador_obs_padrao');
            $table->dropColumn('denominador_obs_padrao');
        });
    }
}
