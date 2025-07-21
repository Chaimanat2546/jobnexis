<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $fillable = [
        'e_name',
        'e_description',
        'e_l_id', // FK to lessons
    ];
    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'e_l_id');
    }
    public function question()
    {
        return $this->hasMany(Question::class, 'q_e_id');
    }
}
