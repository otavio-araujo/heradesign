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
            $table->integer('preco')->default(0);
            $table->string('tecido')->nullable();
            $table->integer('prazo_entrega');
            $table->boolean('fita_led')->default(false);
            $table->boolean('separadores')->default(false);
            $table->text('observacoes')->nullable();
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
