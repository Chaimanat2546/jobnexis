<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $fillable = ['name'];

    public function courses()
    {
        return $this->belongsToMany(
            Course::class,
            'course_skill', // ชื่อตาราง pivot
            'skill_id',     // foreign key ของ Skill ใน pivot
            'c_id'          // foreign key ของ Course ใน pivot
        );
    }
}
