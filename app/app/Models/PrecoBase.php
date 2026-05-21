<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrecoBase extends Model
{
    use HasFactory;

    protected $table = 'precos_base';
    protected $primaryKey = 'preco_id';
    public $timestamps = false;

    protected $fillable = [
        'prc_cod_prod',
        'prc_valor',
        'prc_moeda',
        'prc_desc',
        'prc_acres',
        'prc_promo',
        'prc_dt_ini_promo',
        'prc_dt_fim_promo',
        'prc_dt_atual',
        'prc_origem',
        'prc_tipo_cli',
        'prc_vend_resp',
        'prc_obs',
        'prc_status',
    ];
}
