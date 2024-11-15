<?php

namespace App\Services;

use App\Repositories\MeetingRoomRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Validation\ValidationException;

class MeetingRoomService
{
    protected $repository;

    public function __construct(MeetingRoomRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getAllRooms()
    {
        return $this->repository->getAllRooms();
    }

    public function getRoomById($id)
    {
        $room = $this->repository->getRoomById($id);
        if (!$room) {
            throw new \Exception("Room not found", 404);
        }
        return $room;
    }

    public function createRoom(Request $request)
    {
        $this->validateRequest($request);

        $availability = $request->input('disponibilidade', [
            ['inicio' => '08:00', 'fim' => '09:00'],
            ['inicio' => '09:00', 'fim' => '10:00'],
            ['inicio' => '10:00', 'fim' => '11:00'],
            ['inicio' => '11:00', 'fim' => '12:00'],
            ['inicio' => '13:00', 'fim' => '14:00'],
            ['inicio' => '14:00', 'fim' => '15:00'],
            ['inicio' => '15:00', 'fim' => '16:00'],
            ['inicio' => '16:00', 'fim' => '17:00']
        ]);

        $request->merge(['disponibilidade' => $availability]);

        return $this->repository->createRoom($request->all());
    }

    public function updateRoom(Request $request, $id)
    {
        $this->validateRequest($request, true);

        $room = $this->repository->getRoomById($id);
        if (!$room) {
            throw new \Exception("Room not found", 404);
        }

        $availability = $request->input('disponibilidade', $room->disponibilidade);
        $request->merge(['disponibilidade' => $availability]);

        return $this->repository->updateRoom($room, $request->all());
    }

    public function deleteRoom($id)
    {
        $room = $this->repository->getRoomById($id);
        if (!$room) {
            throw new \Exception("Room not found", 404);
        }
        $this->repository->deleteRoom($room);
    }

    public function getOccupancyData()
    {
        $occupancies = $this->repository->getOccupancyData();

        if (!$occupancies) {
            throw new \Exception("No occupancy data found", 404);
        }

        return [
            'labels' => array_column($occupancies, 'room'),
            'data' => array_column($occupancies, 'hours'),
        ];
    }

    public function getOccupiedHours($roomId, $date)
    {
        $validatedDate = Carbon::createFromFormat('Y-m-d', $date);
        if (!$validatedDate) {
            throw ValidationException::withMessages(['date' => 'Invalid date format']);
        }

        return $this->repository->getOccupiedHours($roomId, $validatedDate);
    }

    public function checkAvailability($roomId, $date, $startTime, $endTime)
    {
        try {
            $validatedDate = Carbon::createFromFormat('Y-m-d', $date);
            $validatedStartTime = Carbon::createFromFormat('H:i', $startTime);
            $validatedEndTime = Carbon::createFromFormat('H:i', $endTime);
        } catch (\Exception $e) {
            throw ValidationException::withMessages([
                'date' => 'Invalid date or time format.',
            ]);
        }

        if ($validatedStartTime->greaterThanOrEqualTo($validatedEndTime)) {
            throw new \Exception('Start time must be earlier than end time.');
        }

        $occupiedHours = $this->repository->getOccupiedHours($roomId, $validatedDate);

        foreach ($occupiedHours as $hour) {
            $start = Carbon::parse($hour->start_time);
            $end = Carbon::parse($hour->end_time);

            if ($validatedStartTime->between($start, $end) || $validatedEndTime->between($start, $end)) {
                return false;
            }
        }

        return true;
    }

    public function updateAvailability($roomId, $availability)
    {
        return $this->repository->updateAvailability($roomId, $availability);
    }

    private function validateRequest(Request $request, $isUpdate = false)
    {
        $rules = $this->getValidationRules($isUpdate);
        $request->validate($rules);
    }

    private function getValidationRules($isUpdate)
    {
        return [
            'nome' => $isUpdate ? 'sometimes|required|string|max:255' : 'required|string|max:255',
            'localizacao' => $isUpdate ? 'sometimes|required|string|max:255' : 'required|string|max:255',
            'capacidade' => $isUpdate ? 'sometimes|required|integer' : 'required|integer',
            'recursos' => 'nullable|array',
            'descricao' => 'nullable|string',
            'disponibilidade' => 'nullable|array', 
        ];
    }
}
