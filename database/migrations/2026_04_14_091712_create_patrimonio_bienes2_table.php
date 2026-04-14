<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('patrimonio_bienes2', function (Blueprint $table) {
            $table->id();
            
            $table->string('codigo_patrimonial', 100)->nullable();
            $table->string('descripcion', 255)->nullable();
            $table->string('nombre_sede', 150)->nullable();
            $table->string('nombre_depend', 150)->nullable();
            $table->string('responsable', 150)->nullable();
            $table->string('usuario', 150)->nullable();
            $table->string('nombre_prov', 150)->nullable();

            $table->date('fecha_compra')->nullable();
            $table->decimal('valor_compra', 12, 2)->nullable();
            $table->date('fecha_alta')->nullable();
            $table->decimal('valor_inicial', 12, 2)->nullable();

            $table->string('sede', 100)->nullable();
            $table->string('pliego', 100)->nullable();
            $table->string('ubicac_fisica', 150)->nullable();
            $table->string('nombre_item', 150)->nullable();
            $table->string('sec_ejec', 50)->nullable();
            $table->string('tipo_modalidad', 100)->nullable();
            $table->string('codigo_barra', 100)->nullable();
            $table->string('modelo', 100)->nullable();
            $table->string('nro_orden', 100)->nullable();
            $table->string('medidas', 100)->nullable();

            $table->decimal('hvalor_neto', 12, 2)->nullable();
            $table->string('abrev_movimto', 50)->nullable();
            $table->string('secuencia', 50)->nullable();
            $table->string('nro_documento', 100)->nullable();
            $table->string('flag_compartido', 10)->nullable();

            $table->string('marca', 100)->nullable();
            $table->string('centro_costo', 100)->nullable();
            $table->string('estado', 50)->nullable();
            $table->string('abreviatura', 50)->nullable();

            $table->date('fecha_nea')->nullable();
            $table->string('tipo_doc_refer', 100)->nullable();
            $table->string('sec_modelo', 50)->nullable();
            $table->string('nro_serie', 100)->nullable();

            $table->string('grupo_bien', 100)->nullable();
            $table->string('clase_bien', 100)->nullable();
            $table->string('familia_bien', 100)->nullable();
            $table->string('item_bien', 100)->nullable();

            $table->string('color', 50)->nullable();
            $table->text('caracteristicas')->nullable();
            $table->text('observaciones')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patrimonio_bienes2');
    }
};
