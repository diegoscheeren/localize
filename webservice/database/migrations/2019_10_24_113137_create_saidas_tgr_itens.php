<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateSaidasTgrItens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(
            "CREATE OR REPLACE FUNCTION baixar_estoque() RETURNS TRIGGER AS $$
                BEGIN
                    IF (TG_OP = 'INSERT') THEN
                        update itens set estoque = ((select estoque from itens where id = NEW.item) - NEW.quantidade)
                            where id = NEW.item;
                        RETURN NEW;
                    END IF;
                END;
            $$ LANGUAGE 'plpgsql' SECURITY DEFINER;

            CREATE TRIGGER tgr_baixar_estoque AFTER INSERT ON saidas FOR EACH ROW EXECUTE PROCEDURE baixar_estoque();"
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
            "drop function if exists baixar_estoque();
            drop trigger if exists tgr_baixar_estoque on saidas;"
        );
    }
}
