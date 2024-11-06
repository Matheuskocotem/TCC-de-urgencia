<?php

namespace App\Http\Controllers;

use App\Models\Meeting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MeetingController extends Controller
{
    // Listar todas as reuniões
    public function index()
    {
        $meetings = Meeting::with('user', 'room')->get(); 
        return response()->json($meetings);
    }

    public function getMeetingsByDay($date)
    {
        // Valida a data recebida
        $validatedDate = Carbon::createFromFormat('Y-m-d', $date);
        
        // Busca as reuniões para a data especificada
        $meetings = Meeting::whereDate('meeting_date', $validatedDate)->get();

        return response()->json($meetings);
    }


    // Criar uma nova reunião
    public function store(Request $request)
    {
        $this->validateRequest($request);
    
        // Parse do horário de início e fim
        $startTime = Carbon::parse($request->start_time);
        $endTime = Carbon::parse($request->end_time);
    
        // Verifica se o horário de início está dentro do intervalo de trabalho (08:00 - 17:00)
        if (!$this->isWithinWorkingHours($startTime)) {
            return response()->json(['error' => true, 'message' => 'As reuniões só podem ser agendadas entre 08:00 e 17:00.'], 400);
        }
    
        // Verifica conflito de horários
        if ($this->hasTimeConflict($request->room_id, $startTime, $endTime)) {
            return response()->json(['error' => true, 'message' => 'Conflito de horário com outra reunião.'], 409); 
        }
    
        // Criação da reunião
        $meeting = Meeting::create([
            'user_id' => Auth::id(),
            'room_id' => $request->room_id,
            'title' => $request->title,
            'description' => $request->description,
            'start_time' => $startTime,
            'end_time' => $endTime,
        ]);
    
        return response()->json($meeting, 201);
    }
    
    private function validateRequest(Request $request)
    {
        $request->validate([
            'room_id' => 'required|exists:meeting_rooms,id',
            'title' => 'required|string',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);
    }
    
    private function isWithinWorkingHours(Carbon $startTime)
    {
        // Verifica se o horário está dentro do intervalo de trabalho das 08:00 às 17:00
        return $startTime->hour >= 8 && $startTime->hour < 17;
    }
    
    private function hasTimeConflict($meetingRoomId, Carbon $startTime, Carbon $endTime)
    {
        // Verifica se há conflito de horários para a mesma sala
        return Meeting::where('room_id', $meetingRoomId)
                      ->where(function ($query) use ($startTime, $endTime) {
                          $query->whereBetween('start_time', [$startTime, $endTime])
                                ->orWhereBetween('end_time', [$startTime, $endTime])
                                ->orWhere(function ($query) use ($startTime, $endTime) {
                                    $query->where('start_time', '<=', $startTime)
                                          ->where('end_time', '>=', $endTime);
                                });
                      })
                      ->exists();
    }
    

    // Mostrar uma reunião específica
    public function show($id)
    {
        $meeting = Meeting::with('user', 'room')->findOrFail($id); 
        return response()->json($meeting);
    }

    // Atualizar uma reunião específica
    public function update(Request $request, $id)
    {
        $meeting = Meeting::findOrFail($id);
        
        $this->authorize('update', $meeting);

        $this->validateRequest($request);

        // Verifica se o horário está dentro do expediente e se há conflitos
        $startTime = Carbon::parse($request->start_time);
        $endTime = Carbon::parse($request->end_time);
        
        if ($this->isOutsideWorkHours($startTime)) {
            return response()->json(['error' => true, 'message' => 'Não é possível agendar reuniões fora do horário de trabalho.'], 400);
        }

        if ($this->hasTimeConflict($request->room_id, $startTime, $endTime)) {
            return response()->json(['error' => true, 'message' => 'Conflito de horário com outra reunião.'], 409);
        }

        $meeting->update($request->all());
        return response()->json($meeting);
    }

    // Deletar uma reunião específica
    public function destroy($id)
    {
        $meeting = Meeting::findOrFail($id);
        
        $this->authorize('delete', $meeting);

        $meeting->delete();
        return response()->json(['message' => 'Reunião deletada com sucesso!']);
    }
}
