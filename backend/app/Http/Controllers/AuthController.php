<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\Meeting;
use App\Models\MeetingRoom;

class AuthController extends Controller
{

    public function getSummaryData()
    {
        // Contagem total de reuniões
        $totalReservas = Meeting::count();
    
        // Contagem total de salas de reunião
        $salasDisponiveis = MeetingRoom::count();
    
        // Contagem total de usuários
        $totalUsuarios = User::count(); // Conta todos os usuários
    
        // Retornar os dados em uma única resposta JSON
        return response()->json([
            'totalReservas' => $totalReservas,
            'salasDisponiveis' => $salasDisponiveis,
            'totalUsuarios' => $totalUsuarios, // Renomeado para totalUsuarios
        ]);
    }
    

    public function index(Request $request)
    {

    if (auth()->user()->role !== 'admin') {
        return response()->json(['message' => 'Acesso negado. Apenas administradores podem visualizar todos os usuários.'], 403);
    }

    $users = User::select('id', 'name', 'email', 'cpf', 'role', 'created_at')->get();

    return response()->json(['users' => $users]);
    }   

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

    public function addAdmin(Request $request) 
    {
    $request->validate([
        'name' => 'required|string',
        'email' => 'required|string|email|unique:users',
        'cpf' => 'required|string|max:11|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    if (auth()->check() && auth()->user()->role !== 'admin') {
        return response()->json(['message' => 'Acesso negado. Somente administradores podem adicionar outros administradores.'], 403);
    }

    $admin = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'cpf' => $request->cpf,
        'password' => Hash::make($request->password),
        'role' => 'admin', 
    ]);

    return response()->json(['message' => 'Administrador registrado com sucesso!']);
    }

    public function updateAdmin(Request $request, $id) 
    {

    $request->validate([
        'name' => 'sometimes|required|string',
        'email' => 'sometimes|required|string|email|unique:users,email,' . $id,
        'cpf' => 'sometimes|required|string|max:11|unique:users,cpf,' . $id,
        'password' => 'sometimes|required|string|min:8|confirmed|nullable',
    ]);

    if (auth()->check() && auth()->user()->role !== 'admin') {
        return response()->json(['message' => 'Acesso negado. Somente administradores podem atualizar outros administradores.'], 403);
    }

    $admin = User::findOrFail($id);

    $admin->name = $request->name ?? $admin->name;
    $admin->email = $request->email ?? $admin->email;
    $admin->cpf = $request->cpf ?? $admin->cpf;

    if ($request->filled('password')) {
        $admin->password = Hash::make($request->password);
    }
    $admin->save();

    return response()->json(['message' => 'Administrador atualizado com sucesso!']);
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
        return response()->json([
            'token' => $token,
            'role' => $user->role 
        ]);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logout realizado com sucesso!']);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)])
            : response()->json(['message' => __($status)], 400);
    }



    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required|string',
            'email' => 'required|email',
            'password' => 'required|string|confirmed',
        ]);


        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json(['message' => 'Usuário não encontrado.'], 404);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return response()->json(['message' => 'Senha atualizada com sucesso.']);
    }

    

    public function showResetForm($token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

}