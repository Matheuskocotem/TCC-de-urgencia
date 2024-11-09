<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class UserService
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function getAllUsers()
    {
        return $this->userRepository->getAllUsers();
    }

    public function registerUser($data)
    {
        $data['password'] = Hash::make($data['password']);
        return $this->userRepository->createUser($data);
    }

    public function addAdmin($data)
    {
        $data['role'] = 'admin';
        return $this->registerUser($data);
    }

    public function updateAdmin($id, $data)
    {
        $user = $this->userRepository->findUserById($id);

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->updateUser($user, $data);
    }

    public function updateUser($id, $data, $isAdmin = false)
    {
        $user = $this->userRepository->findUserById($id);

        if ($isAdmin && isset($data['role'])) {
            $user->role = $data['role'];
        }

        if (isset($data['password'])) {
            $data['password'] = Hash::make($data['password']);
        }

        return $this->userRepository->updateUser($user, $data);
    }

    public function deleteUser($id)
    {
        $user = $this->userRepository->findUserById($id);
        return $this->userRepository->deleteUser($user);
    }

    public function loginUser($cpf, $password)
    {
        $user = $this->userRepository->getUserByCpf($cpf);

        if (!$user || !Hash::check($password, $user->password)) {
            throw ValidationException::withMessages([
                'cpf' => ['As credenciais fornecidas estão incorretas.'],
            ]);
        }

        $token = $user->createToken('token-name')->plainTextToken;
        return ['token' => $token, 'role' => $user->role];
    }

    public function logoutUser($user)
    {
        $user->currentAccessToken()->delete();
        return ['message' => 'Logout realizado com sucesso!'];
    }

    public function getSummaryData()
    {
        return [
            'totalReservas' => \App\Models\Meeting::count(),
            'salasDisponiveis' => \App\Models\MeetingRoom::count(),
            'totalUsuarios' => $this->userRepository->countUsers(),
        ];
    }
}
