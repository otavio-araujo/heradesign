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
        Schema::create('contas_receber', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('status_conta_id');
            $table->unsignedBigInteger('plano_conta_id');
            $table->unsignedBigInteger('categoria_conta_id');
            $table->unsignedBigInteger('forma_pagamento_id');
            $table->unsignedBigInteger('conta_corrente_id');
            $table->foreignId('proposal_id')->constrained();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('customer_id')->constrained();
            $table->text('descricao');
            $table->string('documento')->nullable();
            $table->string('observacoes')->nullable();
            $table->integer('qtd_parcelas');
            $table->integer('parcela_atual');
            $table->decimal('valor_previsto', 12, 2);
            $table->decimal('valor_parcela', 12, 2);
            $table->decimal('valor_descontos', 12, 2)->nullable();
            $table->decimal('valor_acrescimos', 12, 2)->nullable();
            $table->decimal('valor_pago', 12, 2)->nullable();
            $table->date('vencimento_em');
            $table->date('pago_em')->nullable();
            $table->date('liquidado_em')->nullable();
            $table->timestamps();

            $table->foreign('status_conta_id')->references('id')->on('status_contas');
            $table->foreign('plano_conta_id')->references('id')->on('planos_contas');
            $table->foreign('categoria_conta_id')->references('id')->on('categorias_contas');
            $table->foreign('forma_pagamento_id')->references('id')->on('formas_pagamentos');
            $table->foreign('conta_corrente_id')->references('id')->on('contas_correntes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contas_receber');
    }
};
