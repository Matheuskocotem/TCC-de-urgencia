<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    // Defina os atributos que podem ser atribuídos em massa
    protected $fillable = [
        'room_id',
        'user_id',
        'title',
        'description',
        'start_time',
        'end_time',
    ];

    /**
     * Relacionamento com a tabela de users
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento com a tabela de meeting_rooms
     */
    public function room()
    {
        return $this->belongsTo(MeetingRoom::class);
    }
}
