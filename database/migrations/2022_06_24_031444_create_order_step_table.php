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
        Schema::create('order_step', function (Blueprint $table) {
<<<<<<< HEAD

=======
>>>>>>> Dev
            $table->id();
            $table->foreignId('order_id')
                ->constrained()
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->foreignId('step_id')
                ->constrained()     
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->date('defined_at');

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
        Schema::dropIfExists('order_step');
    }
};
