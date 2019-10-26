<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
class ChangeEstoqueFunctionPedidoItens extends Migration
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
                        update itens set estoque = ((select estoque from itens where id = OLD.item) + OLD.quantidade)
                            where id = OLD.item;
                        RETURN OLD;
                    END IF;
                END;
            $$ LANGUAGE 'plpgsql' SECURITY DEFINER;"
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
            "drop function if exists movimentar_estoque() CASCADE;"
        );
    }
}
