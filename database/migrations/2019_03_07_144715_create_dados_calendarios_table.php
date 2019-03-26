<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDadosCalendariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dados_calendarios', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('calendario_id');
            $table->unsignedInteger('marcador_id');
            $table->smallInteger('dia');
            $table->smallInteger('ano');
            $table->smallInteger('dia_sabado_letivo')->nullable();

            $table->foreign('calendario_id')
                ->references('id')
                ->on('calendarios')
                ->onDelete('cascade');

            $table->foreign('marcador_id')
                ->references('id')
                ->on('marcadores');

            $table->index('id', 'dados_calendario_idx');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dados_calendarios');
    }
}
