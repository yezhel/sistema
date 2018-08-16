<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProveedoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->string('contacto', 50)->nullable();
            $table->string('telefono_contacto', 50)->nullable();

            //Clave foranea que relaciona con la tabla de persona(de la tabla proveedores el id es la clave foranea y ese id hace referencia al id de personas, tipo de eliminacion es cascada)
            $table->foreign('id')->references('id')->on('personas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('proveedores');
    }
}
