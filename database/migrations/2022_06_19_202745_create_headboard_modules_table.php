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
        Schema::create('headboard_modules', function (Blueprint $table) {
            $table->id();
            $table->foreignId('headboard_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('formato')->nullable()->default('RETANGULAR');
            $table->integer('qtd');
            $table->integer('largura');
            $table->integer('altura');
            $table->string('obs_module')->nullable();
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
        Schema::dropIfExists('headboard_modules');
    }
};
