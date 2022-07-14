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
        Schema::create('contas_correntes', function (Blueprint $table) {
            $table->id();
            $table->string('titular');
            $table->string('banco');
            $table->string('agencia');
            $table->string('conta');
            $table->decimal('saldo_inicial', 12, 2)->default(0);
            $table->decimal('saldo_atual', 12, 2)->default(0);
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
        Schema::dropIfExists('contas_correntes');
    }
};
