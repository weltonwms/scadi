<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddAtualToCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('calculations', function (Blueprint $table) {
             $table->boolean('atual')->nullable()->after('validado_por')->comment('Flag para último valor válido em última referência');
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
            $table->dropColumn('atual');
        });
    }
}
