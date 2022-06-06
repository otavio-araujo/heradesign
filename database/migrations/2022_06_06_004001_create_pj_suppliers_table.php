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
        Schema::create('pj_suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('cnpj', 15)->nullable();
            $table->string('inscricao_estadual', 15)->nullable();
            $table->string('inscricao_municipal', 15)->nullable();
            $table->foreignId('supplier_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');
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
        Schema::dropIfExists('pj_suppliers');
    }
};
