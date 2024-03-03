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
        Schema::table('venta_articulos', function (Blueprint $table) {
            $table->dropColumn('referencia_pago');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('venta_articulos', function (Blueprint $table) {
            $table->string('referencia_pago')->nullable();
        });
    }
};
