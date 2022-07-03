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
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('conta_corrente_id');
            $table->unsignedBigInteger('conta_receber_id');
            $table->decimal('saldo_anterior', 12, 2);
            $table->decimal('saldo_atual', 12, 2);
            $table->decimal('valor', 12, 2);
            $table->timestamps();

            $table->foreign('conta_corrente_id')->references('id')->on('contas_correntes');
            $table->foreign('conta_receber_id')->references('id')->on('contas_receber');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transactions');
    }
};
