<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class CreateSaidasTgrPedidoItens extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::unprepared(
            "CREATE OR REPLACE FUNCTION movimentar_estoque() RETURNS TRIGGER AS $$
                BEGIN
                    IF (TG_OP = 'INSERT') THEN
                        update itens set estoque = ((select estoque from itens where id = NEW.item) - NEW.quantidade)
                            where id = NEW.item;
                        RETURN NEW;
                    END IF;

                    IF (TG_OP = 'DELETE') THEN
                        update itens set estoque = ((select estoque from itens where id = NEW.item) + NEW.quantidade)
                            where id = NEW.item;
                        RETURN NEW;
                    END IF;
                END;
            $$ LANGUAGE 'plpgsql' SECURITY DEFINER;

            drop function if exists baixar_estoque() CASCADE;
            drop trigger if exists tgr_baixar_estoque on saidas;"
        );


        DB::unprepared(
            "drop function if exists baixar_estoque() CASCADE;
            drop trigger if exists tgr_baixar_estoque on saidas;"
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
            "drop trigger if exists tgr_movimentar_estoque on saidas;
            drop function if exists movimentar_estoque() CASCADE;"
        );
    }
}
