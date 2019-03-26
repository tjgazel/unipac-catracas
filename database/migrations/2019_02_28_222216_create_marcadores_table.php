<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarcadoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('marcadores', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('nome', 50)->nullable();
            $table->string('classe', 50)->nullable();
            $table->enum('intervalos', ['0', '1'])->default('0');
            $table->enum('aula_normal', ['0', '1']);
            $table->enum('repor', ['0', '1']);

            $table->index('id', 'marcadores_idx');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('marcadores');
    }
}
