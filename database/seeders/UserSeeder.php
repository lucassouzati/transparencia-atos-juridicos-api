<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'name' => 'Administrador',
            'email' => 'admin@admin.com',
            'password' => bcrypt('teste1234'),
            'profile' => 'admin',
        ]);

        $user = User::create([
            'name' => 'Cidadao',
            'email' => 'cidadao@admin.com',
            'password' => bcrypt('teste1234'),
            'profile' => 'citizen',
        ]);
    }
}
