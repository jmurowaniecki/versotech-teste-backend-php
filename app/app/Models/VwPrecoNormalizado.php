<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VwPrecoNormalizado extends Model
{
    protected $table = 'vw_precos_normalizados';
    public $timestamps = false;
    protected $primaryKey = 'preco_id';
    protected $guarded = [];
}
