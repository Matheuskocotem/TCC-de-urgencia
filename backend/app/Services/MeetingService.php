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

    public function getAllMeetings()
    {
        return $this->meetingRepository->getAllMeetings();
    }

    public function getMeetingsByDate($date)
    {
        $validatedDate = Carbon::createFromFormat('Y-m-d', $date);
        return $this->meetingRepository->getMeetingsByDate($validatedDate);
    }

    public function createMeeting(array $data)
    {
        $startTime = Carbon::parse($data['start_time']);
        $endTime = Carbon::parse($data['end_time']);

        if ($this->isOutsideWorkHours($startTime)) {
            throw new \Exception('Não é possível agendar reuniões fora do horário de trabalho.');
        }

        if ($this->meetingRepository->hasTimeConflict($data['room_id'], $startTime, $endTime)) {
            throw new \Exception('Conflito de horário com outra reunião.');
        }

        $data['user_id'] = Auth::id();
        return $this->meetingRepository->createMeeting($data);
    }

    public function updateMeeting($id, array $data)
    {
        $meeting = $this->meetingRepository->findMeetingById($id);

        $startTime = Carbon::parse($data['start_time']);
        $endTime = Carbon::parse($data['end_time']);

        if ($this->isOutsideWorkHours($startTime)) {
            throw new \Exception('Não é possível agendar reuniões fora do horário de trabalho.');
        }

        if ($this->meetingRepository->hasTimeConflict($data['room_id'], $startTime, $endTime)) {
            throw new \Exception('Conflito de horário com outra reunião.');
        }

        return $this->meetingRepository->updateMeeting($meeting, $data);
    }

    public function deleteMeeting($id)
    {
        $meeting = $this->meetingRepository->findMeetingById($id);
        return $this->meetingRepository->deleteMeeting($meeting);
    }

    private function isOutsideWorkHours(Carbon $startTime)
    {
        return $startTime->isBefore(Carbon::createFromTime(8, 0)) ||
            ($startTime->between(Carbon::createFromTime(11, 30), Carbon::createFromTime(13, 0))) ||
            $startTime->isAfter(Carbon::createFromTime(17, 0));
    }
}
