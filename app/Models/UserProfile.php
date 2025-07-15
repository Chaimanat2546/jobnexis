<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    use HasFactory;

    protected $primaryKey = 'up_id';

    protected $fillable = [
        'up_prefix',
        'up_first_name',
        'up_last_name',
        'up_address',
        'up_city',
        'up_country',
        'up_birth_date',
        'up_gender',
        'up_nationality',
        'up_phone',
        'up_u_id', // FK ไปยัง users
    ];

    protected $casts = [
        'up_birth_date' => 'date',
    ];

    // ความสัมพันธ์: UserProfile -> User
    public function user()
    {
        return $this->belongsTo(User::class, 'up_u_id');
    }
}
