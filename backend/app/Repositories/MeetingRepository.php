<?php

namespace App\Repositories;

use App\Models\Meeting;
use Carbon\Carbon;

class MeetingRepository
{
    public function getAllMeetings()
    {
        return Meeting::with('user', 'room')->get();
    }

    public function getMeetingsByDate(Carbon $date)
    {
        return Meeting::whereDate('meeting_date', $date)->get();
    }

    public function createMeeting(array $data)
    {
        return Meeting::create($data);
    }

    public function findMeetingById($id)
    {
        return Meeting::with('user', 'room')->findOrFail($id);
    }

    public function updateMeeting(Meeting $meeting, array $data)
    {
        $meeting->update($data);
        return $meeting;
    }

    public function deleteMeeting(Meeting $meeting)
    {
        return $meeting->delete();
    }

    public function hasTimeConflict($meetingRoomId, Carbon $startTime, Carbon $endTime)
    {
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
}
