<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('produto_insercao', function (Blueprint $table) {
            $table->id('prod_ins_id');
            $table->string('prod_cod', 30)->unique()->index();
            $table->string('prod_nome', 150)->nullable();
            $table->string('prod_categoria', 50)->nullable()->index();
            $table->string('prod_subcategoria', 50)->nullable();
            $table->text('prod_descricao')->nullable();
            $table->string('prod_fabricante', 100)->nullable();
            $table->string('prod_modelo', 50)->nullable();
            $table->string('prod_cor', 30)->nullable();
            $table->decimal('prod_peso', 10, 3)->nullable();
            $table->decimal('prod_largura', 10, 2)->nullable();
            $table->decimal('prod_altura', 10, 2)->nullable();
            $table->decimal('prod_profundidade', 10, 2)->nullable();
            $table->string('prod_unidade', 10)->nullable();
            $table->boolean('prod_ativo')->default(true)->index();
            $table->date('prod_data_cadastro')->nullable()->index();
            $table->timestamp('prod_data_processamento')->useCurrent();
            $table->string('prod_hash_origem', 64)->nullable();
            $table->text('prod_observacao')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('produto_insercao');
    }
};
