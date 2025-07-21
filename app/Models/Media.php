<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Media extends Model
{
    use HasFactory;
    protected $primaryKey = 'm_id';
    protected $fillable = [
        'm_name',
        'm_path',
        'm_index',
        'm_l_id', // FK to lessons
    ];
    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'm_l_id');
    }
}
