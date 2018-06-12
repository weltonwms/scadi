<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIndicatorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('indicators', function (Blueprint $table) {
            $table->increments('id');
            $table->string('sigla');
            $table->string('name');
            $table->text('description')->nullable();
            $table->integer('periodicidade'); 
            $table->integer('index_id')->unsigned();
            
            
            $table->string('numerador_sigla');
            $table->string('numerador_name');
            $table->text('numerador_description')->nullable();
            $table->float('numerador_valor_padrao')->nullable();
            $table->boolean('numerador_habilitado');
            
            
            $table->string('denominador_sigla');
            $table->string('denominador_name');
            $table->text('denominador_description')->nullable();
            $table->float('denominador_valor_padrao')->nullable();
            $table->boolean('denominador_habilitado');
            
            
            $table->timestamps();
            $table->foreign('index_id')->references('id')->on('indices');
           
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('indicators');
    }
}
