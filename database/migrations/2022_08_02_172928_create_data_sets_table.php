<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDataSetsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('data_sets', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('idcontrato');
            $table->string('nAnuncio');
            $table->text('tipoContrato');
            $table->text('tipoprocedimento');
            $table->string('objectoContrato');
            $table->text('adjudicantes');
            $table->text('adjudicatarios');
            $table->string('dataPublicacao');
            $table->string('dataCelebracaoContrato');
            $table->bigInteger('precoContratual');
            $table->text('cpv');
            $table->string('prazoExecucao');
            $table->text('localExecucao');
            $table->text('fundamentacao');
            $table->boolean('read')->default(false);
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
        Schema::dropIfExists('data_sets');
    }
}
