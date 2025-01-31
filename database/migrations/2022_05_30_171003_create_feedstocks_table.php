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
        Schema::create('feedstocks', function (Blueprint $table) {
            $table->id();
            $table->string('nome', 150)->unique();
            $table->foreignId('unidade_medida_id')->default(1)->constrained();
            $table->foreignId('feedstock_type_id')->default(1)->constrained();
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
        Schema::dropIfExists('feedstocks');
    }
};
