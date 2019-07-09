<?php

use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nivelAcesso')->insert([
            'id' => 1,
            'nome' => 'Administrador',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('nivelAcesso')->insert([
            'id' => 2,
            'nome' => 'Agente de Produção',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('nivelAcesso')->insert([
            'id' => 3,
            'nome' => 'Garçom',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('users')->insert([
            'name' => 'administrador',
            'email' => 'administrador@admin.com',
            'password' => bcrypt('1234567'),
            'ativo' => true,
            'nivelAcesso_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('estacaoProducao')->insert([
            'id' => 1,
            'nome' => 'Estação 1',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('estacaoProducao')->insert([
            'id' => 2,
            'nome' => 'Estação 2',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('estacaoProducao')->insert([
            'id' => 3,
            'nome' => 'Estação 3',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);
        DB::table('mesas')->insert([
            'id' => 1,
            'status' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('mesas')->insert([
            'id' => 2,
            'status' => false,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tipoProduto')->insert([
            'id' => 1,
            'tipo' => 'lanche',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('tipoProduto')->insert([
            'id' => 2,
            'tipo' => 'bebida',
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('produtos')->insert([
            'id' => 1,
            'nome' => 'X Supremo',
            'valor' => 15.00,
            'ingredientes' => 'pão, carne, etc',
            'tipoProduto_id' => 1,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        DB::table('produtos')->insert([
            'id' => 2,
            'nome' => 'Suco Laranja 1L',
            'valor' => 12.00,
            'ingredientes' => 'pão, carne, etc',
            'tipoProduto_id' => 2,
            'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        ]);

        // DB::table('produtos')->insert([
        //     'id' => 3,
        //     'nome' => 'Coca Cola 2L',
        //     'valor' => 10.00,
        //     'ingredientes' => 'pão, carne, etc',
        //     'tipoProduto_id' => 2,
        //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        // ]);

        // DB::table('pedidos')->insert([
        //     'statusPedido' => 'Em produção',
        //     'valor' => 0,
        //     'finalizado' => false,
        //     'mesas_id' => 1,
        //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        // ]);

        // DB::table('itensPedidos')->insert([
        //     'pedidos_id' => 1,
        //     'produtos_id' => 1,
        //     'estacaoProducao_id' => 1,
        //     'statusItemPedido' => false,
        //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        // ]);

        // DB::table('itensPedidos')->insert([
        //     'pedidos_id' => 1,
        //     'produtos_id' => 2,
        //     'estacaoProducao_id' => 2,
        //     'statusItemPedido' => false,
        //     'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
        //     'updated_at' => Carbon::now()->format('Y-m-d H:i:s'),
        // ]);
    }
}
