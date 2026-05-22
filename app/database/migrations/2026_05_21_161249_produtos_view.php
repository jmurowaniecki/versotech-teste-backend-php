<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    private $table_name = "vw_produtos_normalizados";

    /**
     * Símbolo alquímico para 'Destilar/Sublimar'.
     *
     * Usado como marcador único e seguro para purificação de espaços duplicados
     * no SQLite, garantindo que nenhum caractere legítimo do texto seja afetado
     * por engano.
     */
    private const MARCADOR_DESTILAR_SUBLIMAR = '🝠';

    public function up(): void
    {
        $delimitador = self::MARCADOR_DESTILAR_SUBLIMAR;

        DB::statement("CREATE VIEW {$this->table_name} AS
            WITH produtos_tratados AS (
                SELECT
                    prod_id,
                    UPPER(TRIM(prod_cod)) AS codigo,
                    TRIM(
                        REPLACE(
                            REPLACE(
                                REPLACE(
                                    REPLACE(
                                        REPLACE(prod_nome, ' ', ' {$delimitador} '),
                                        ' {$delimitador}',
                                        ''
                                    ),
                                    '{$delimitador} ',
                                    ''
                                ),
                                '  ',
                                ' '
                            ),
                            '  ',
                            ' '
                        )
                    ) AS nome,

                    UPPER(TRIM(prod_cat))    AS categoria,
                    UPPER(TRIM(prod_subcat)) AS subcategoria,
                    TRIM(prod_desc)          AS descricao,
                    TRIM(prod_fab)           AS fabricante,
                    TRIM(prod_mod)           AS modelo,
                    UPPER(TRIM(prod_cor))    AS cor,
                    LOWER(TRIM(prod_peso))   AS peso_original,
                    LOWER(TRIM(prod_und))    AS unidade,

                    REPLACE(REPLACE(LOWER(prod_larg),  'cm', ''), ',', '.') AS largura_original,
                    REPLACE(REPLACE(LOWER(prod_alt),   'cm', ''), ',', '.') AS altura_original,
                    REPLACE(REPLACE(LOWER(prod_prof),  'cm', ''), ',', '.') AS profundidade_original,
                    REPLACE(REPLACE(TRIM(prod_dt_cad), '.', '-'), '/', '-') AS data_original
                FROM produtos_base
                WHERE prod_atv = TRUE
            )

            SELECT
                prod_id,
                codigo,
                nome,
                categoria,
                subcategoria,
                descricao,
                fabricante,
                modelo,
                cor,

                CASE
                    WHEN peso_original LIKE '%kg' THEN CAST(REPLACE(REPLACE(peso_original, 'kg', ''), ',', '.') AS NUMERIC) * 1000
                    WHEN peso_original LIKE '%g'  THEN CAST(REPLACE(REPLACE(peso_original,  'g', ''), ',', '.') AS NUMERIC)
                    ELSE NULL
                END AS peso_gramas,

                unidade,

                CAST(largura_original      AS NUMERIC) AS largura_cm,
                CAST(altura_original       AS NUMERIC) AS altura_cm,
                CAST(profundidade_original AS NUMERIC) AS profundidade_cm,

                CASE
                    WHEN data_original LIKE '__-__-____'
                        THEN substr(data_original, 7, 4) || '-'
                          || substr(data_original, 4, 2) || '-'
                          || substr(data_original, 1, 2)
                    ELSE data_original
                END AS data_cadastro
            FROM produtos_tratados
        ");
    }

    public function down(): void
    {
        DB::statement("DROP VIEW IF EXISTS {$this->table_name}");
    }
};
