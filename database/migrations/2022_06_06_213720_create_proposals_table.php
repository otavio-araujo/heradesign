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
            $table->foreignId('proposal_status_id')->constrained();
            $table->integer('prazo_entrega')->default(30);
            $table->string('pgto_vista')->nullable();
            $table->string('pgto_boleto')->nullable();
            $table->string('pgto_cartao')->nullable();
            $table->string('pgto_outros')->nullable();
            $table->integer('validade')->default(5);
            $table->longText('obs_proposal')->nullable();
            $table->decimal('desconto', 12, 2)->nullable();
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
