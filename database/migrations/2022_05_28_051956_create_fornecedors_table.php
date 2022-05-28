<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fornecedors', function (Blueprint $table) {
            $table->id();
            $table->string('nome_fantasia', 150);
            $table->string('cnpj', 15)->nullable();
            $table->string('cep', 9)->nullable();
            $table->string('endereco')->nullable();
            $table->unsignedInteger('numero')->nullable();
            $table->string('complemento', 100)->nullable();
            $table->string('bairro', 150)->nullable();
            $table->string('cidade', 150)->nullable();
            $table->string('uf', 2)->nullable();
            $table->string('telefone', 15)->nullable();
            $table->string('celular', 15)->nullable();
            $table->string('whatsapp', 15)->nullable();
            $table->string('email')->nullable();
            $table->string('responsavel', 150)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fornecedors');
    }
};
