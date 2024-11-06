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
        Schema::create('pedido_has_materials', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pedido_id')->constrained('pedidos')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->foreignId('material_id')->constrained('materials')->onDelete('CASCADE')->onUpdate('CASCADE');
            $table->integer('quantidade');
            $table->decimal('subtotal', 10, 2);
           // $table->primary(['pedido_id', 'material_id']);
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedido_has_materials');
    }
};
