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
        Schema::create('headboards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('proposal_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('largura');
            $table->integer('altura');
            $table->integer('qtd');
            $table->decimal('valor_unitario', 12, 2);
            $table->decimal('valor_total', 12, 2);
            $table->string('tecido', 150)->default('INDEFINIDO')->nullable();
            $table->boolean('has_led')->default(false);
            $table->string('obs_led')->nullable();
            $table->boolean('has_separador')->default(false);
            $table->string('obs_separador')->nullable();
            $table->boolean('has_tomada')->default(false);
            $table->string('obs_tomada')->nullable();
            $table->integer('qtd_tomada')->nullable();
            $table->string('obs_headboard')->nullable();
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
        Schema::dropIfExists('headboards');
    }
};
