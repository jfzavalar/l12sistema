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
        Schema::create('contabilidades_gastosoperativos', function (Blueprint $table) {
            $table->id();
            $table->integer('anio');
            $table->decimal('enero', 10, 2)->default(0);
            $table->decimal('febrero', 10, 2)->default(0);
            $table->decimal('marzo', 10, 2)->default(0);
            $table->decimal('abril', 10, 2)->default(0);
            $table->decimal('mayo', 10, 2)->default(0);
            $table->decimal('junio', 10, 2)->default(0);
            $table->decimal('julio', 10, 2)->default(0);
            $table->decimal('agosto', 10, 2)->default(0);
            $table->decimal('septiembre', 10, 2)->default(0);
            $table->decimal('octubre', 10, 2)->default(0);
            $table->decimal('noviembre', 10, 2)->default(0);
            $table->decimal('diciembre', 10, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contabilidades_gastosoperativos');
    }
};
