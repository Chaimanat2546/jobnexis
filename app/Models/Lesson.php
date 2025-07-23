<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;
    protected $primaryKey = 'l_id';
    protected $fillable = [
        'l_name',
        'l_description',
        'l_status',
        'l_index',
        'l_c_id', // FK to courses
    ];
    public function isPubliced()
    {
        return $this->getAttribute('l_status') === 'open';
    }
    public function isClosed()
    {
        return $this->getAttribute('l_status') === 'closed';
    }
    public function isDraft()
    {
        return $this->getAttribute('l_status') === 'draft';
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'l_c_id');
    }
    public function media()
    {
        return $this->hasMany(Media::class, 'm_l_id');
    }
}
