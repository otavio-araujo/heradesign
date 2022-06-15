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
        Schema::create('proposals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('proposal_status_id')->default(1)->constrained();
            $table->integer('largura')->default(0);
            $table->integer('altura')->default(0);
            $table->decimal('valor_total', 12, 2)->nullable();
            $table->string('tecido')->nullable();
            $table->integer('prazo_entrega');
            $table->boolean('fita_led')->default(false);
            $table->string('obs_fita_led')->nullable();
            $table->boolean('separadores')->default(false);
            $table->string('obs_separadores')->nullable();
            $table->boolean('tomadas')->default(false);
            $table->integer('qtd_tomadas')->nullable();
            $table->string('obs_tomadas')->nullable();
            $table->string('pgto_a_vista')->nullable();
            $table->string('pgto_boleto')->nullable();
            $table->string('pgto_cartao')->nullable();
            $table->string('pgto_outros')->nullable();
            $table->longText('observacoes')->nullable();
            $table->integer('validade_dias')->default(5);
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
        Schema::dropIfExists('proposals');
    }
};
