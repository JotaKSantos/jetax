<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jetax_playground_clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('razao_social')->nullable();
            $table->string('documento', 20)->nullable();
            $table->string('cidade', 80)->nullable();
            $table->string('estado', 2)->nullable();
            $table->string('status', 20)->default('ativo');
            $table->string('categoria', 20)->default('bronze');
            $table->timestamps();

            $table->index('status');
            $table->index('categoria');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jetax_playground_clientes');
    }
};
