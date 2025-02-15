<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInstitucionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('INSTITUCION', function (Blueprint $table) {
            $table->id('ITC_CODIGO');
            $table->string('ITC_CODIGO_MODULAR', 20);
            $table->string('ITC_NOMBRE', 100);
            $table->string('ITC_DIRECTOR', 100);
            $table->string('ITC_LOGO', 255)->nullable();
            $table->timestamp('ITC_CREATED')->nullable();
            $table->timestamp('ITC_UPDATED')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('INSTITUCION');
    }
}
