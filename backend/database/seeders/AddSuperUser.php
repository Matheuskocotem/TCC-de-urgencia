<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Faker\Factory as Faker;

$faker = Faker::create();

foreach (range(1, 200) as $index) {
    User::create([
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'cpf' => $faker->cpf,
        'password' => Hash::make('password123'), // Use a senha padrão ou gere uma senha aleatória
        'role' => 'user', // Atribuindo o role 'user'
        'created_at' => now(),
        'updated_at' => now(),
    ]);
}