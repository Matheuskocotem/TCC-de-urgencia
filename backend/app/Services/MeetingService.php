<?php

namespace App\Services;

use App\Repositories\MeetingRepository;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class MeetingService
{
    protected $meetingRepository;

    public function __construct(MeetingRepository $meetingRepository)
    {
        $this->meetingRepository = $meetingRepository;
    }

    public function getMeetingById($id)
    {
        return $this->meetingRepository->findMeetingById($id);
    }


    public function getAllMeetings()
    {
        return $this->meetingRepository->getAllMeetings();
    }

    public function getMeetingsByDate($date)
    {
        $validatedDate = Carbon::parse($date);
        return $this->meetingRepository->getMeetingsByDate($validatedDate);
    }

    public function createMeeting(array $data)
    {
        $startTime = Carbon::createFromFormat('Y-m-d H:i', $data['date'] . ' ' . $data['start_time'])->setTimezone('America/Sao_Paulo');
        $endTime = Carbon::createFromFormat('Y-m-d H:i', $data['date'] . ' ' . $data['end_time'])->setTimezone('America/Sao_Paulo');

        $data['date'] = $startTime->format('Y-m-d');

        if ($this->meetingRepository->hasTimeConflict($data['room_id'], $startTime, $endTime)) {
            throw new \Exception('Conflito de horário com outra reunião.');
        }

        $room = $this->meetingRepository->findRoomById($data['room_id']);
        if (!$room) {
            throw new \Exception('Sala não encontrada.');
        }

        $data['user_id'] = Auth::id();

        return $this->meetingRepository->createMeeting($data);
    }

    public function updateMeeting($id, array $data)
    {
        $meeting = $this->meetingRepository->findMeetingById($id);

        if (!$meeting) {
            throw new \Exception('Reunião não encontrada.');
        }

        $startTime = Carbon::createFromFormat('Y-m-d H:i', $data['date'] . ' ' . $data['start_time'])->setTimezone('America/Sao_Paulo');
        $endTime = Carbon::createFromFormat('Y-m-d H:i', $data['date'] . ' ' . $data['end_time'])->setTimezone('America/Sao_Paulo');

        if ($this->meetingRepository->hasTimeConflict($data['room_id'], $startTime, $endTime)) {
            throw new \Exception('Conflito de horário com outra reunião.');
        }

        return $this->meetingRepository->updateMeeting($meeting, $data);
    }
    
    public function updateMeetingStatus($id, string $status)
    {
        $meeting = $this->meetingRepository->findMeetingById($id);

        if (!$meeting) {
            throw new \Exception('Reunião não encontrada.');
        }

        return $this->meetingRepository->updateMeetingStatus($meeting, $status);
    }

    public function deleteMeeting($id)
    {
        $meeting = $this->meetingRepository->findMeetingById($id);
        return $this->meetingRepository->deleteMeeting($meeting);
    }
}
