<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruitment extends Model
{
     protected $table = 'recruitments';
    protected $primaryKey = 'rc_id';

    protected $fillable = [
        'rc_title',
        'r_description',
        'rc_requirements',
        'rc_salary',
        'rc_location_link',
        'rc_type',
        'rc_status',
        'rc_posted_at',
        'rc_expire_at',
        'rc_u_id',
    ];
   public function user()
    {
        return $this->belongsTo(User::class, 'rc_u_id');
    }
}
