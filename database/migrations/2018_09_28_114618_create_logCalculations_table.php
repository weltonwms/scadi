<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLogCalculationsTable extends Migration {

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up() {
        Schema::create('log_calculations', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('indicator_id')->unsigned();
            $table->integer('user_id')->unsigned(); //author
            $table->date('data_inicio'); //data de inicio dos valores
            $table->date('data_final')->nullable(); //data de inicio dos valores
            $table->double('valor_numerador');
            $table->double('valor_denominador');
            $table->string('obs_numerador')->nullable();
            $table->string('obs_denominador')->nullable();
            $table->boolean('validado')->nullable();
            $table->integer('validado_por')->nullable()->unsigned(); //revisor
            $table->boolean('atual')->nullable();
            $table->dateTime('created_at')->nullable();
            $table->dateTime('updated_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->integer('deletado_por')->nullable()->unsigned()->comment('user_id do usuário que deletou');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::dropIfExists('log_calculations');
    }

}
