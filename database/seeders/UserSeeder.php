<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Paciente 1';
        $user->email = 'p1@email.com';
        $user->password = bcrypt('p1@123');
        $user->save();
    }
}
