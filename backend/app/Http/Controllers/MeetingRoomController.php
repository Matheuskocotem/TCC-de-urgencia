<?php

namespace App\Http\Controllers;

use App\Models\MeetingRoom;
use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Carbon\Carbon; 

class MeetingRoomController extends Controller
{
    public function index()
    {
        return MeetingRoom::all(); 
    }

    public function getOccupancyData()
    {
        $meetingRooms = MeetingRoom::all();
        $occupancies = [];

        foreach ($meetingRooms as $room) {
            // Aqui você pode definir a lógica para contar as horas ocupadas
            // Supondo que você tenha um relacionamento com a tabela meetings
            $totalHours = Meeting::where('meeting_room_id', $room->id)
                ->sum('duration'); // 'duration' deve ser o campo que representa as horas da reunião

            $occupancies[] = [
                'room' => $room->name, // Supondo que você tenha um campo 'name' na tabela rooms
                'hours' => $totalHours,
            ];
        }

        return response()->json([
            'labels' => array_column($occupancies, 'room'),
            'data' => array_column($occupancies, 'hours'),
        ]);
    }

    public function getOccupiedHours($roomId, $date)
    {
        $validatedDate = Carbon::createFromFormat('Y-m-d', $date);

        $occupiedMeetings = Meeting::where('meeting_room_id', $roomId)
            ->whereDate('meeting_date', $validatedDate)
            ->get(['start_time', 'end_time']);

        return response()->json($occupiedMeetings);
    }

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


    public function show($id)
    {
        $room = MeetingRoom::findOrFail($id);
        return response()->json($room); 
    }

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


    public function destroy($id)
    {
        $room = MeetingRoom::findOrFail($id); 
        $room->delete(); 
        return response()->json(null, Response::HTTP_NO_CONTENT); 
    }
}
