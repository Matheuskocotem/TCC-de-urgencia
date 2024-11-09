<?php

namespace App\Services;

use App\Repositories\MeetingRoomRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
        return $this->repository->getRoomById($id);
    }

    public function createRoom(Request $request)
    {
        $this->validateRequest($request);
        return $this->repository->createRoom($request->all());
    }

    public function updateRoom(Request $request, $id)
    {
        $this->validateRequest($request, true);

        $room = $this->repository->getRoomById($id);
        return $this->repository->updateRoom($room, $request->all());
    }

    public function deleteRoom($id)
    {
        $room = $this->repository->getRoomById($id);
        $this->repository->deleteRoom($room);
    }

    public function getOccupancyData()
    {
        $occupancies = $this->repository->getOccupancyData();
        return [
            'labels' => array_column($occupancies, 'room'),
            'data' => array_column($occupancies, 'hours'),
        ];
    }

    public function getOccupiedHours($roomId, $date)
    {
        $validatedDate = Carbon::createFromFormat('Y-m-d', $date);
        return $this->repository->getOccupiedHours($roomId, $validatedDate);
    }

    private function validateRequest(Request $request, $isUpdate = false)
    {
        $rules = [
            'nome' => $isUpdate ? 'sometimes|required|string|max:255' : 'required|string|max:255',
            'localizacao' => $isUpdate ? 'sometimes|required|string|max:255' : 'required|string|max:255',
            'capacidade' => $isUpdate ? 'sometimes|required|integer' : 'required|integer',
            'recursos' => 'nullable|array',
            'imagem' => 'nullable|string',
            'descricao' => 'nullable|string',
        ];

        $request->validate($rules);
    }
}
