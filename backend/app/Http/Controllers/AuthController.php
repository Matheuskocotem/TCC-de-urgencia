<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request) 
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'cpf' => 'required|string|max:11|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);
    
        $role = $request->input('role', 'user');
    
        if (auth()->check() && auth()->user()->role === 'admin') {
            $role = $request->input('role', 'user');
        } else {
            $role = 'user';
        }
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'cpf' => $request->cpf,
            'password' => Hash::make($request->password),
            'role' => $role,
        ]);
    
        return response()->json(['message' => 'Usuário registrado com sucesso!']);
    }
    
    public function update(Request $request, $id) 
    {
        $user = User::findOrFail($id);
    
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users,email,' . $user->id,
            'cpf' => 'required|string|max:11|unique:users,cpf,' . $user->id,
            'password' => 'sometimes|required|string|min:8|confirmed',
        ]);
    
        if (auth()->user()->role === 'admin') {
            $request->validate(['role' => 'required|string|in:admin,user']);
            $user->role = $request->role;
        }
    
        $user->name = $request->name;
        $user->email = $request->email;
        $user->cpf = $request->cpf;
        
        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }
    
        $user->save();
    
        return response()->json(['message' => 'Usuário atualizado com sucesso!']);
    }
    

    public function delete(Request $request, $id) 
    {
    $user = User::findOrFail($id);

    $user->delete();

    return response()->json(['message' => 'Usuário deletado com sucesso!']);
    }


    public function login(Request $request) 
    {
        $request->validate([
            'cpf' => 'required|string|regex:/^\d{11}$/', 
            'password' => 'required|string',
        ]);
    
        $user = User::where('cpf', $request->cpf)->first();
    
        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'cpf' => ['As credenciais fornecidas estão incorretas.'],
            ]);
        }
    
        $token = $user->createToken('token-name')->plainTextToken;
        return response()->json(['token' => $token]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso!']);
    }
}