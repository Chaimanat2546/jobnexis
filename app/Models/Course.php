<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;
    protected $primaryKey = 'c_id';
    protected $fillable = [
        'c_name',
        'c_description',
        'c_create_by_id',
        'c_number',
        'c_create_at',
        'c_end_at',
        'c_status',
    ];
    public function isPubliced()
    {
        return $this->getAttribute('c_status') === 'open';
    }
    public function isClosed()
    {
        return $this->getAttribute('c_status') === 'closed';
    }
    public function isDraft()
    {
        return $this->getAttribute('c_status') === 'draft';
    }
    public function coursesMember()
    {
        return $this->hasMany(CourseMember::class, 'cm_c_id');
    }
    public function lessons()
    {
        return $this->hasMany(Lesson::class, 'l_c_id');
    }
    public function certificate()
    {
        return $this->hasMany(Certificates::class, 'cer_c_id');
    }
}
