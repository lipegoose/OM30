<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEnderecosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('enderecos', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_paciente');
            $table->string('cep',100)->nullable();
            $table->string('estado',2)->nullable();
            $table->string('cidade',200)->nullable();
            $table->string('bairro',200)->nullable();
            $table->string('endereco',200)->nullable();
            $table->string('numero',50)->nullable();
            $table->string('complemento',200)->nullable();
            $table->timestamp('deleted_at')->nullable();
            $table->timestamps();

            $table->foreign('id_paciente')->references('id')->on('pacientes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('enderecos');
    }
}
