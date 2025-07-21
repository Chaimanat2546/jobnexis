<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompaniesProfile extends Model
{
    use HasFactory;
    protected $fillable = [
        'co_name',
        'co_tagline',
        'co_description',
        'co_website',
        'co_email',
        'co_phone',
        'co_logo',
        'co_address',
        'co_city',
        'co_country',
        'co_founded_at',
        'co_user_id',
    ];
    public function recrument()
    {
        return $this->hasMany(Recruitment::class, 'rc_co_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'co_user_id');
    }
}
