<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class VwProdutoNormalizadoTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function strips_html_and_trims_nome()
    {
        DB::table('produtos_base')->insert([
            'codigo' => 'P-001',
            'nome_orig' => "<b> Produto </b> \n ",
            'descricao_orig' => '<script>alert(1)</script>desc',
        ]);

        $row = DB::table('vw_produto_normalizado')->where('codigo', 'P-001')->first();
        $this->assertNotNull($row, 'View retornou nulo para P-001');
        $this->assertEquals('Produto', trim($row->nome));
        $this->assertStringNotContainsString('<', $row->descricao);
    }

    /** @test */
    public function normalizes_codigo_and_removes_duplicates()
    {
        DB::table('produtos_base')->insert([
            ['codigo' => 'p-002', 'nome_orig' => 'A'],
            ['codigo' => 'P-002', 'nome_orig' => 'A duplicado'],
        ]);

        $rows = DB::table('vw_produto_normalizado')->where('codigo', 'P-002')->get();
        $this->assertTrue($rows->count() >= 1);
        $this->assertEquals('P-002', $rows->first()->codigo);
    }
}
