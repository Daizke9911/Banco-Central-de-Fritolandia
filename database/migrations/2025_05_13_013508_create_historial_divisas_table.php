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
        Schema::create('historial_divisas', function (Blueprint $table) {
            $table->id();
            $table->string('cuentaDebitada');
            $table->string('cuentaDepositada');
            $table->float('venta');
            $table->string('monedaVenta');
            $table->float('compra');
            $table->string('monedaCompra');
            $table->string('concepto');
            $table->foreignId('user_id')
            ->constrained()
            ->onDelete('cascade')
            ->onUpdate('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial_divisas');
    }
};
