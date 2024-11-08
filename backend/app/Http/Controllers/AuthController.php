<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\ForgotPasswordRequest;
use App\Http\Requests\ResetPasswordRequest;
use App\Http\Requests\DeleteUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterUserRequest $request): JsonResponse
    {
        $user = $this->userService->registerUser($request->validated());
        return response()->json(['user' => $user, 'message' => 'User registered successfully'], 201);
    }

    public function login(LoginRequest $request): JsonResponse
    {
        $token = $this->userService->loginUser($request->cpf, $request->password);
        if (!$token) {
            return response()->json(['message' => 'Invalid credentials'], 401);
        }
        return response()->json(['token' => $token], 200);
    }

    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        $user = $this->userService->updateUser($id, $request->validated());
        return response()->json(['user' => $user, 'message' => 'User updated successfully'], 200);
    }

    public function delete(DeleteUserRequest $request, $id): JsonResponse
    {
        $user = $this->userService->deleteUser($id);
        return response()->json(['user' => $user, 'message' => 'User deleted successfully'], 200);
    }

    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        $token = $this->userService->forgotPassword($request->email);
        if (!$token) {
            return response()->json(['message' => 'Email not found'], 404);
        }
        return response()->json(['token' => $token, 'message' => 'Reset token created'], 200);
    }

    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        $user = $this->userService->resetPassword($request->validated());
        return response()->json(['user' => $user, 'message' => 'Password reset successfully'], 200);
    }
}
