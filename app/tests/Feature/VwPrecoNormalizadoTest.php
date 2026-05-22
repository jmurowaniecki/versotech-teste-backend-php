<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class VwPrecoNormalizadoTest extends TestCase
{
    use RefreshDatabase;

    /**
     * normalização de código, colapsamento de espaços no nome, conversão de peso para gramas, conversão de medidas e data de cadastro.
     * parsing e normalização de valores monetários, moeda, percentuais, promoções e tratamento de "sem preço" como NULL */
    public function test_parses_and_normalizes_price_and_fields()
    {
        DB::table('precos_base')->insert([
            'prc_cod_prod'  => ' PRD001 ',
            'prc_valor'     => ' 499,90 ',
            'prc_moeda'     => 'brl',
            'prc_desc'      => '5%',
            'prc_promo'     => '474,90',
            'prc_dt_atual'  => '2025-10-15',
            'prc_tipo_cli'  => 'VAREJO',
            'prc_vend_resp' => 'Marcos Silva',
            'prc_origem'    => 'SISTEMA ERP',
            'prc_obs'       => 'Produto em destaque',
            'prc_status'    => 'ativo',
        ]);

        $row = DB::table('vw_precos_normalizados')->where('codigo_produto', 'PRD001')->first();
        $this->assertNotNull($row);
        $this->assertEquals('PRD001', $row->codigo_produto);
        $this->assertEquals(499.90, (float) $row->valor);
        $this->assertEquals('BRL', $row->moeda);
        $this->assertEquals(5, (int) $row->percentual_desconto);
        $this->assertEquals(474.90, (float) $row->valor_promocional);
        $this->assertEquals('VAREJO', $row->tipo_cliente);
        $this->assertEquals('MARCOS SILVA', $row->vendedor);
    }

    /** @test */
    public function test_sem_preco_as_null()
    {
        DB::table('precos_base')->insert([
            'prc_cod_prod' => 'PRD999',
            'prc_valor'    => 'sem preço',
            'prc_status'   => 'ativo',
        ]);

        $row = DB::table('vw_precos_normalizados')->where('codigo_produto', 'PRD999')->first();
        $this->assertNotNull($row);
        $this->assertNull($row->valor);
    }
}
