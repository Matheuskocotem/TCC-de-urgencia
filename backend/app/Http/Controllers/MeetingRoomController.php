<?php

namespace App\Http\Controllers;

use App\Services\MeetingRoomService;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class MeetingRoomController extends Controller
{
    protected $service;

    public function __construct(MeetingRoomService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $rooms = $this->service->getAllRooms();
        return response()->json($rooms);
    }

    public function getOccupancyData()
    {
        $occupancyData = $this->service->getOccupancyData();
        return response()->json($occupancyData);
    }

    public function getOccupiedHours($roomId, $date)
    {
        $occupiedHours = $this->service->getOccupiedHours($roomId, $date);
        return response()->json($occupiedHours);
    }

    public function checkAvailability(Request $request, $roomId)
    {
        $validated = $request->validate([
            'date' => 'required|date_format:Y-m-d',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
        ]);

        $isAvailable = $this->service->checkAvailability(
            $roomId,
            $validated['date'],
            $validated['start_time'],
            $validated['end_time']
        );

        return response()->json(['available' => $isAvailable], Response::HTTP_OK);
    }

    public function updateAvailability(Request $request, $roomId)
    {
        // Validação da disponibilidade como um array
        $validated = $request->validate([
            'disponibilidade' => 'required|array',
            'disponibilidade.*' => 'required|array',
            'disponibilidade.*.inicio' => 'required|date_format:H:i',
            'disponibilidade.*.fim' => 'required|date_format:H:i',
        ]);

        // Atualiza a disponibilidade da sala
        $updatedRoom = $this->service->updateAvailability($roomId, $validated['disponibilidade']);
        return response()->json($updatedRoom, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        try {
            $room = $this->service->createRoom($request);
            return response()->json($room, Response::HTTP_CREATED);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validação falhou',
                'errors' => $e->errors(),
            ], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function show($id)
    {
        $room = $this->service->getRoomById($id);
        return response()->json($room);
    }

    public function update(Request $request, $id)
    {
        $updatedRoom = $this->service->updateRoom($request, $id);
        return response()->json($updatedRoom);
    }

    public function destroy($id)
    {
        $this->service->deleteRoom($id);
        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
