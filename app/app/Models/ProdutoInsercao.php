<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProdutoInsercao extends Model
{
    use HasFactory;

    protected $table = 'produto_insercao';
    protected $primaryKey = 'prod_ins_id';
    public $timestamps = false;

    protected $fillable = [
        'prod_cod',
        'prod_nome',
        'prod_categoria',
        'prod_subcategoria',
        'prod_descricao',
        'prod_fabricante',
        'prod_modelo',
        'prod_cor',
        'prod_peso',
        'prod_largura',
        'prod_altura',
        'prod_profundidade',
        'prod_unidade',
        'prod_ativo',
        'prod_data_cadastro',
        'prod_data_processamento',
        'prod_hash_origem',
        'prod_observacao',
    ];

    public function precos()
    {
        return $this->hasMany(PrecoInsercao::class, 'prod_cod', 'prod_cod');
    }
}
