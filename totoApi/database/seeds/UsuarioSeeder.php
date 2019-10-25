<?php

use Illuminate\Database\Seeder;
use App\Usuario;
class UsuarioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new Usuario;
        $user->email = 'hernandes@gmail.com';
        $user->password = bcrypt('password');        
        $user->save();
    }
}
