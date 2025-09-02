<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;
    protected $primaryKey = 'e_id';
    protected $fillable = [
        'e_name',
        'e_description',
        'e_l_id', // FK to lessons (nullable)
        'e_c_id', // เพิ่ม FK to courses
        'e_index', // เพิ่มลำดับ
    ];

    // Relationships
    public function lesson()
    {
        return $this->belongsTo(Lesson::class, 'e_l_id', 'l_id');
    }

    // เพิ่ม relationship กับ course
    public function course()
    {
        return $this->belongsTo(Course::class, 'e_c_id', 'c_id');
    }

    // แก้ไขชื่อ method จาก question เป็น questions
    public function questions()
    {
        return $this->hasMany(Question::class, 'q_e_id', 'e_id')->orderBy('q_order');
    }
}
