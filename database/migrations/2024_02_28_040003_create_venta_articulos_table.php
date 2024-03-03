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
        Schema::create('venta_articulos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_venta')->constrained('ventas');
            $table->foreignId('id_stock')->constrained('stocks');
            $table->integer('cantidad');
            $table->decimal('precio', 8, 2);
            $table->string('tipo_pago');
            $table->string('referencia_pago');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('venta_articulos');
    }
};
