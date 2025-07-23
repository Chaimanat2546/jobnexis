<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Recruitment extends Model
{
    use HasFactory;
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
        'rc_co_id',
        'rc_user_id',
    ];
    public function companies()
    {
        return $this->belongsTo(CompaniesProfile::class, 'rc_co_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'rc_user_id');
    }
}
