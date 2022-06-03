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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 150)->unique();
            $table->string('nome_fantasia', 15)->nullable();
            $table->string('contato', 150)->nullable();
            $table->string('telefone', 15)->nullable();
            $table->string('celular', 15)->nullable();
            $table->string('whatsapp', 15)->nullable();
            $table->string('email')->nullable();
            $table->string('cep', 9)->nullable();
            $table->string('endereco')->nullable();
            $table->string('bairro', 150)->nullable();
            $table->string('numero')->nullable();
            $table->string('complemento', 100)->nullable();
            $table->foreignId('cidade_id')->constrained()->default(1);
            $table->foreignId('person_type_id')->constrained()->default(1);
            $table->foreignId('partner_id')->constrained()->default(1);
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
        Schema::dropIfExists('customers');
    }
};
