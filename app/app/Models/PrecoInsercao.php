<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrecoInsercao extends Model
{
    use HasFactory;

    protected $table = 'preco_insercao';
    protected $primaryKey = 'preco_ins_id';
    public $timestamps = false;

    protected $fillable = [
        'prod_cod',
        'preco_valor',
        'preco_moeda',
        'preco_desconto_percentual',
        'preco_acrescimo_percentual',
        'preco_promocional',
        'preco_data_inicio_promocao',
        'preco_data_fim_promocao',
        'preco_data_atualizacao',
        'preco_origem',
        'preco_tipo_cliente',
        'preco_vendedor_responsavel',
        'preco_observacao',
        'preco_status',
        'preco_data_processamento',
        'preco_hash_origem',
    ];

    public function produto()
    {
        return $this->belongsTo(ProdutoInsercao::class, 'prod_cod', 'prod_cod');
    }
}
