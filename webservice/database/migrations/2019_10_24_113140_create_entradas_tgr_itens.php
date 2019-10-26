<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateEntradasTgrItens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(
            "CREATE OR REPLACE FUNCTION entrada_estoque() RETURNS TRIGGER AS $$
                BEGIN
                    IF (TG_OP = 'INSERT') THEN
                        update itens set estoque = ((select estoque from itens where id = NEW.item) + NEW.quantidade)
                            where id = NEW.item;
                        RETURN NEW;
                    END IF;
                END;
            $$ LANGUAGE 'plpgsql' SECURITY DEFINER;

            CREATE TRIGGER tgr_entrada_estoque AFTER INSERT ON entradas FOR EACH ROW EXECUTE PROCEDURE entrada_estoque();"
        );
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared(
            "drop function if exists entrada_estoque();
            drop trigger if exists tgr_entrada_estoque on entradas;"
        );
    }
}
