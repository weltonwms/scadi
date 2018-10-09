<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPeriodicidadeToCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calculations', function (Blueprint $table) {
            $table->integer('periodicidade')->nullable()->after('data_final');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('calculations', function (Blueprint $table) {
            $table->dropColumn('periodicidade');
        });
    }
}
