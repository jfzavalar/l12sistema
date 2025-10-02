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
        Schema::create('tblsedes', function (Blueprint $table) {
            $table->id();
            $table->string('codsedeofi');
            $table->string('sedepofi');
            $table->string('nomsedeofi');
            $table->string('anomdepofi');
            $table->string('estado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tblsedes');
    }
};
