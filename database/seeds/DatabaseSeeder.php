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

        factory(\App\Talla::class, 1)->create(['nombre' => '6', 'descripcion' => 'talla 6']);
        factory(\App\Talla::class, 1)->create(['nombre' => '8', 'descripcion' => 'talla 8']);
        factory(\App\Talla::class, 1)->create(['nombre' => '10', 'descripcion' => 'talla 10']);
        factory(\App\Talla::class, 1)->create(['nombre' => '12', 'descripcion' => 'talla 12']);
        factory(\App\Talla::class, 1)->create(['nombre' => '14', 'descripcion' => 'talla 14']);
        factory(\App\Talla::class, 1)->create(['nombre' => '16', 'descripcion' => 'talla 16']);
        factory(\App\Talla::class, 1)->create(['nombre' => '20', 'descripcion' => 'talla 20']);
        factory(\App\Talla::class, 1)->create(['nombre' => '21', 'descripcion' => 'talla 21']);
        factory(\App\Talla::class, 1)->create(['nombre' => '22', 'descripcion' => 'talla 22']);
        factory(\App\Talla::class, 1)->create(['nombre' => '23', 'descripcion' => 'talla 23']);
        factory(\App\Talla::class, 1)->create(['nombre' => '24', 'descripcion' => 'talla 24']);
        factory(\App\Talla::class, 1)->create(['nombre' => '25', 'descripcion' => 'talla 25']);
        factory(\App\Talla::class, 1)->create(['nombre' => '26', 'descripcion' => 'talla 26']);
        factory(\App\Talla::class, 1)->create(['nombre' => '27', 'descripcion' => 'talla 27']);
        factory(\App\Talla::class, 1)->create(['nombre' => '28', 'descripcion' => 'talla 28']);
        factory(\App\Talla::class, 1)->create(['nombre' => '29', 'descripcion' => 'talla 29']);
        factory(\App\Talla::class, 1)->create(['nombre' => '30', 'descripcion' => 'talla 30']);
        factory(\App\Talla::class, 1)->create(['nombre' => '31', 'descripcion' => 'talla 31']);
        factory(\App\Talla::class, 1)->create(['nombre' => '32', 'descripcion' => 'talla 32']);
        factory(\App\Talla::class, 1)->create(['nombre' => '33', 'descripcion' => 'talla 33']);
        factory(\App\Talla::class, 1)->create(['nombre' => '34', 'descripcion' => 'talla 34']);
        factory(\App\Talla::class, 1)->create(['nombre' => '35', 'descripcion' => 'talla 35']);
        factory(\App\Talla::class, 1)->create(['nombre' => '36', 'descripcion' => 'talla 36']);
        factory(\App\Talla::class, 1)->create(['nombre' => '37', 'descripcion' => 'talla 37']);
        factory(\App\Talla::class, 1)->create(['nombre' => '38', 'descripcion' => 'talla 38']);
        factory(\App\Talla::class, 1)->create(['nombre' => '39', 'descripcion' => 'talla 39']);
        factory(\App\Talla::class, 1)->create(['nombre' => '40', 'descripcion' => 'talla 40']);
        factory(\App\Talla::class, 1)->create(['nombre' => '41', 'descripcion' => 'talla 41']);
        factory(\App\Talla::class, 1)->create(['nombre' => '42', 'descripcion' => 'talla 42']);








    }
}
