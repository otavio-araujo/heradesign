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
        Schema::create('receivables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained();
            $table->foreignId('order_id')->constrained();
            $table->foreignId('customer_id')->constrained();
            $table->foreignId('billing_status_id')->constrained();
            $table->foreignId('billing_type_id')->constrained();
            $table->string('descricao')->nullable();
            $table->integer('qtd_parcelas');
            $table->integer('parcela_atual');
            $table->decimal('valor_total', 12, 2);
            $table->decimal('valor_parcela', 12, 2);
            $table->decimal('valor_desconto', 12, 2)->nullable();
            $table->decimal('valor_acrescimo', 12, 2)->nullable();
            $table->decimal('valor_pago', 12, 2)->nullable();
            $table->date('vencimento_em');
            $table->date('pago_em');
            $table->date('liquidado_em');
            $table->string('documento')->nullable();
            $table->string('observacoes');
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
        Schema::dropIfExists('receivables');
    }
};
