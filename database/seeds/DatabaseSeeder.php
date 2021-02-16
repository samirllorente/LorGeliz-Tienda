<?php

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
        factory(\App\Role::class, 1)->create(['nombre' => 'cliente', 'descripcion' => 'usuario con rol cliente']);
        factory(\App\Role::class, 1)->create(['nombre' => 'administrador', 'descripcion' => 'usuario con rol administrador']);

        factory(\App\User::class, 1)->create()

            ->each(function (App\User $u){
                factory(\App\Cliente::class, 1)->create(['user_id' => $u->id]);
            });

    }
}
