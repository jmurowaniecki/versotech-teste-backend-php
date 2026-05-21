<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('preco_insercao', function (Blueprint $table) {
            $table->id('preco_ins_id');
            $table->string('prod_cod', 30)->index();
            $table->decimal('preco_valor', 12, 2)->nullable();
            $table->string('preco_moeda', 10)->default('BRL');
            $table->decimal('preco_desconto_percentual', 5, 2)->nullable();
            $table->decimal('preco_acrescimo_percentual', 5, 2)->nullable();
            $table->decimal('preco_promocional', 12, 2)->nullable();
            $table->date('preco_data_inicio_promocao')->nullable();
            $table->date('preco_data_fim_promocao')->nullable();
            $table->date('preco_data_atualizacao')->nullable()->index();
            $table->string('preco_origem', 50)->nullable();
            $table->string('preco_tipo_cliente', 30)->nullable()->index();
            $table->string('preco_vendedor_responsavel', 100)->nullable();
            $table->text('preco_observacao')->nullable();
            $table->string('preco_status', 20)->default('ativo')->index();
            $table->timestamp('preco_data_processamento')->useCurrent();
            $table->string('preco_hash_origem', 64)->nullable();

            $table->index(['preco_data_inicio_promocao', 'preco_data_fim_promocao']);

            $table->foreign('prod_cod')
                ->references('prod_cod')
                ->on('produto_insercao')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('preco_insercao');
    }
};
