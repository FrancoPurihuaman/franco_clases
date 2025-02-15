<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNivelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('NIVEL', function (Blueprint $table) {
            $table->id('NIV_CODIGO');
            $table->string('NIV_NOMBRE', 20);
            $table->string('NIV_DESCRIPCION', 255)->nullable();
            $table->timestamp('NIV_CREATED')->nullable();
            $table->timestamp('NIV_UPDATED')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('NIVEL');
    }
}
