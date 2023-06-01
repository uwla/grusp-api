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
        Schema::create('grupos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->text('descricao');

            // campos opcionais
            $table->text('contato')->nullable();        // informações de contato
            $table->text('horario')->nullable();        // horários de encontro
            $table->text('links')->nullable();          // links para redes sociais, grupos de mensagem, etc
            $table->text('lugar')->nullable();          // ponto de encontro
            $table->text('mensalidade')->nullable();    // mensalidade
            $table->text('publico')->nullable();        // público alvo

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('grupos');
    }
};
