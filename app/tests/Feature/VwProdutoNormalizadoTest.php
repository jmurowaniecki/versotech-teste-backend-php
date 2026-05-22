<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class VwProdutoNormalizadoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function test_normalizes_and_converts_fields()
    {
        DB::table('produtos_base')->insert([
            'prod_cod'    => ' PRD001',
            'prod_nome'   => '   Teclado  Mecânico   RGB  ',
            'prod_cat'    => 'PERIFERICOS',
            'prod_subcat' => 'TECLADOS',
            'prod_desc'   => 'Teclado com iluminação RGB e switches azuis',
            'prod_fab'    => 'HyperTech',
            'prod_mod'    => 'HT-KEY-RGB',
            'prod_cor'    => 'Preto',
            'prod_peso'   => '1,2kg ',
            'prod_larg'   => '45 cm',
            'prod_alt'    => '5 CM ',
            'prod_prof'   => '15cm ',
            'prod_und'    => 'UN ',
            'prod_atv'    => true,
            'prod_dt_cad' => '2025/10/10',
        ]);

        $row = DB::table('vw_produtos_normalizados')->where('codigo', 'PRD001')->first();
        $this->assertNotNull($row);
        $this->assertEquals('PRD001', $row->codigo);
        $this->assertEquals('Teclado Mecânico RGB', $row->nome);
        $this->assertEquals(1200, (int) $row->peso_gramas);
        $this->assertEquals(45, (float) $row->largura_cm);
        $this->assertEquals('2025-10-10', $row->data_cadastro);
    }

    /** @test */
    public function test_ignores_inactive_products()
    {
        DB::table('produtos_base')->insert([
            'prod_cod'  => ' PRD005',
            'prod_nome' => 'HEADSET gamer 7.1',
            'prod_atv'  => false,
        ]);

        $row = DB::table('vw_produtos_normalizados')->where('codigo', 'PRD005')->first();
        $this->assertNull($row);
    }
}
