<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VwProdutoNormalizado extends Model
{
    protected $table = 'vw_produtos_normalizados';
    public $timestamps = false;
    protected $primaryKey = 'prod_id';
    protected $guarded = [];
}
