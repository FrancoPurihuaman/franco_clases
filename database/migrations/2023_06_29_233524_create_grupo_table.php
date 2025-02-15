<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGrupoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('GRUPO', function (Blueprint $table) {
            $table->id('GRP_CODIGO');
            $table->string('GRP_SECCION', 20);
            $table->String('GRP_TIPO_PERIODO', 20);
            $table->tinyInteger('GRP_TOTAL_PERIODOS');
            $table->tinyInteger('GRP_PERIODO_ACTUAL');
            $table->date('GRP_FECHA_INICIO');
            $table->date('GRP_FECHA_CIERRE');
            $table->tinyInteger('GRP_ESTADO');
            $table->timestamp('GRP_CREATED')->nullable();
            $table->timestamp('GRP_UPDATED')->nullable();
            $table->unsignedBigInteger('NIV_CODIGO');
            $table->foreign('NIV_CODIGO')->references('NIV_CODIGO')->on('NIVEL');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('GRUPO');
    }
}
