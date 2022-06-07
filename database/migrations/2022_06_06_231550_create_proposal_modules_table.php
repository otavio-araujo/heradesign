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
        Schema::create('proposal_modules', function (Blueprint $table) {
            $table->id();
            $table->string('formato', 50)->nullable();
            $table->integer('largura')->default(0);
            $table->integer('altura')->default(0);
            $table->integer('quantidade')->default(0);
            $table->text('observacoes')->nullable();
            $table->foreignId('proposal_id')->constrained();
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
        Schema::dropIfExists('proposal_modules');
    }
};
