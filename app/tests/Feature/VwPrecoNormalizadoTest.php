<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class VwPrecoNormalizadoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function parses_currency_strings_to_decimal()
    {
        DB::table('produtos_base')->insert(['codigo' => 'PX-01', 'nome_orig' => 'X']);
        DB::table('precos_base')->insert([
            'codigo_produto' => 'PX-01',
            'preco_orig' => 'R$ 1.234,56',
        ]);

        $row = DB::table('vw_preco_normalizado')->where('codigo_produto', 'PX-01')->first();
        $this->assertNotNull($row);
        $this->assertEquals(1234.56, (float) $row->preco);
    }

    /** @test */
    public function handles_null_or_invalid_price_as_null()
    {
        DB::table('produtos_base')->insert(['codigo' => 'PX-02', 'nome_orig' => 'Y']);
        DB::table('precos_base')->insert([
            'codigo_produto' => 'PX-02',
            'preco_orig' => 'sem preço',
        ]);

        $row = DB::table('vw_preco_normalizado')->where('codigo_produto', 'PX-02')->first();
        $this->assertNotNull($row);
        $this->assertNull($row->preco);
    }
}
