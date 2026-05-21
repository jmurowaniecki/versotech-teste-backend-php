<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table_name = "vw_precos_normalizados";

    /**
     * Símbolo Alquímico para 'Uma Metade' / Semis.
     *
     * Utilizado como marcador temporário do separador decimal
     * durante o processo de normalização monetária.
     *
     * Isso permite preservar o delimitador decimal legítimo
     * enquanto separadores de milhar são removidos com segurança.
     */
    private const MARCADOR_SEMIS = '🝜';

    private function normalizarValorMonetario(string $campo, string $alias): string
    {
        $decimal = self::MARCADOR_SEMIS;

        return /* sql */ <<<SQL
                CASE
                    WHEN LOWER(TRIM({$campo})) = 'sem preço'
                        THEN NULL

                    WHEN {$campo} IS NULL
                        THEN NULL

                    ELSE CAST(
                        REPLACE(
                            REPLACE(
                                REPLACE(
                                    CASE
                                        WHEN substr(TRIM({$campo}), -3, 1) IN ('.', ',')
                                            THEN
                                                substr(TRIM({$campo}), 1, length(TRIM({$campo})) - 3)
                                                || '{$decimal}'
                                                || substr(TRIM({$campo}), -2)

                                        ELSE TRIM({$campo})
                                    END,
                                    '.',
                                    ''
                                ),
                                ',',
                                ''
                            ),
                            '{$decimal}',
                            '.'
                        ) AS NUMERIC
                    )
                END AS {$alias}
        SQL;
    }

    private function normalizarDadoPercentual(string $campo, string $alias): string
    {
        return /* sql */ <<<SQL
                CASE
                    WHEN TRIM({$campo}) = ''   THEN 0
                    WHEN      {$campo} IS NULL THEN 0
                    ELSE CAST(
                        TRIM(REPLACE({$campo}, '%', '')) AS NUMERIC
                    )
                END AS {$alias}
        SQL;
    }

    public function up(): void
    {
        DB::statement("CREATE VIEW {$this->table_name} AS
            SELECT
                preco_id,

                UPPER(TRIM(prc_cod_prod)) AS codigo_produto,

                {$this->normalizarValorMonetario('prc_valor', 'valor')},

                UPPER(TRIM(prc_moeda)) AS moeda,

                {$this->normalizarDadoPercentual('prc_desc',  'percentual_desconto')},
                {$this->normalizarDadoPercentual('prc_acres', 'percentual_acrescimo')},
                {$this->normalizarValorMonetario('prc_promo', 'valor_promocional')},

                UPPER(TRIM(prc_tipo_cli))  AS tipo_cliente,
                UPPER(TRIM(prc_vend_resp)) AS vendedor,
                UPPER(TRIM(prc_origem))    AS origem,
                TRIM(prc_obs)              AS observacao,
                LOWER(TRIM(prc_status))    AS status
            FROM precos_base
            WHERE LOWER(TRIM(prc_status)) = 'ativo';
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS {$this->table_name}");
    }
};
