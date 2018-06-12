<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalculationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
       Schema::create('calculations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('indicator_id')->unsigned();
            $table->integer('user_id')->unsigned(); //author
            $table->date('data_inicio'); //data de inicio dos valores
            $table->double('valor_numerador');
            $table->double('valor_denominador');
            $table->string('obs_numerador')->nullable();
            $table->string('obs_denominador')->nullable();
            $table->boolean('validado')->nullable();
            $table->integer('validado_por')->nullable()->unsigned(); //revisor
            $table->timestamps();
            

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('validado_por')->references('id')->on('users');
            $table->foreign('indicator_id')->references('id')->on('indicators')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calculations');
    }
}
