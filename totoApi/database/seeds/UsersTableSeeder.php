<?php

use Illuminate\Database\Seeder;
use App\User;
class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $superadmin = User::create([
            'email' => 'hernandes@gmail.com',
            'password' => bcrypt('12345'),
          ]);
    
    }
}
