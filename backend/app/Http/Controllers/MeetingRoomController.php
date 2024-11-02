<?php

namespace App\Http\Controllers;

use App\Models\MeetingRoom;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MeetingRoomController extends Controller
{
    public function index()
    {
        return MeetingRoom::all(); 
    }

    /**
     * Armazena uma nova sala de reunião.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nome' => 'required|string|max:255',
            'localizacao' => 'required|string|max:255',
            'capacidade' => 'required|integer',
            'recursos' => 'nullable|array',
            'imagem' => 'nullable|string',
            'descricao' => 'nullable|string',
        ]);

        $room = MeetingRoom::create($request->all()); 
        return response()->json($room, Response::HTTP_CREATED); 
    }

    /**
     * Exibe a sala de reunião especificada.
     */
    public function show($id)
    {
        $room = MeetingRoom::findOrFail($id); // Busca a sala pelo ID
        return response()->json($room); // Retorna a sala como JSON
    }

    /**
     * Atualiza a sala de reunião especificada.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'nome' => 'sometimes|required|string|max:255',
            'localizacao' => 'sometimes|required|string|max:255',
            'capacidade' => 'sometimes|required|integer',
            'recursos' => 'nullable|array',
            'imagem' => 'nullable|string',
            'descricao' => 'nullable|string',
        ]);

        $room = MeetingRoom::findOrFail($id); 
        $room->update($request->all()); 
        return response()->json($room); 
    }

    /**
     * Remove a sala de reunião especificada.
     */
    public function destroy($id)
    {
        $room = MeetingRoom::findOrFail($id); 
        $room->delete(); // Deleta a sala
        return response()->json(null, Response::HTTP_NO_CONTENT); 
    }
}
