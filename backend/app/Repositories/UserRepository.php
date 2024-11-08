<?php

namespace App\Repositories;

use App\Models\User;

class UserRepository
{
    public function create(array $data)
    {
        return User::create($data);
    }

    public function update(User $user, array $data)
    {
        $user->update($data);
        return $user;
    }

    public function delete(User $user)
    {
        return $user->delete();
    }

    public function findByEmail(string $email)
    {
        return User::where('email', $email)->first();
    }

    public function findByCpf(string $cpf)
    {
        return User::where('cpf', $cpf)->first();
    }

    public function findById(int $id)
    {
        return User::find($id);
    }
}
