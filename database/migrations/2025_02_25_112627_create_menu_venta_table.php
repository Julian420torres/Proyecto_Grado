<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('menu_venta', function (Blueprint $table) {
            $table->id();
            $table->foreignId('venta_id')->constrained('ventas')->onDelete('cascade'); // Relación con ventas
            $table->foreignId('menu_id')->constrained('menus')->onDelete('cascade'); // Relación con menú
            $table->integer('cantidad'); // Cantidad vendida
            $table->decimal('precio_unitario', 10, 2); // Precio unitario del menú
            $table->decimal('subtotal', 10, 2); // Precio total de la venta de este menú
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('menu_venta');
    }
};
