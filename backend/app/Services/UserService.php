<?php

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use Illuminate\Support\Facades\Password;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function registerUser(array $data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->create($data);
    }

    public function updateUser(User $user, array $data)
    {
        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }
        return $this->userRepository->update($user, $data);
    }

    public function deleteUser(User $user)
    {
        return $this->userRepository->delete($user);
    }

    public function loginUser(string $cpf, string $password)
    {
        $user = $this->userRepository->findByCpf($cpf);
        if (!$user || !Hash::check($password, $user->password)) {
            return null;
        }
        return $user->createToken('auth_token')->plainTextToken;
    }

    public function forgotPassword(string $email)
    {
        $user = $this->userRepository->findByEmail($email);
        if (!$user) {
            return null;
        }

        $token = Password::createToken($user);
        return $token;
    }

    public function resetPassword(array $data)
    {
        $user = $this->userRepository->findByEmail($data['email']);
        if (!$user) {
            return null;
        }

        $user->password = Hash::make($data['password']);
        $user->setRememberToken(Str::random(60));
        $user->save();

        return $user;
    }
}
