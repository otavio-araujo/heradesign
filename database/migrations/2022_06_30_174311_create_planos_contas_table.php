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
        Schema::create('planos_contas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('tipo_conta_id');
            $table->string('nome')->unique();
            $table->timestamps();

            $table->foreign('tipo_conta_id')->references('id')->on('tipos_contas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('planos_contas');
    }
};
