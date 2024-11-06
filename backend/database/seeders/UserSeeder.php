<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Criar um usuário admin
        User::create([
            'name' => 'Admin User',
            'email' => 'admin4@example.com',
            'cpf' => '12344608982', // CPF fixo para o admin
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        // Criar 200 usuários com role 'user'
        $faker = Faker::create();

        foreach (range(10, 200) as $index) {
            User::create([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'cpf' => $faker->numerify('###.###.###-##'), // Gerando CPF no formato correto
                'password' => Hash::make('password123'), 
                'role' => 'user', 
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
