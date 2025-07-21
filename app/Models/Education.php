<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
    protected $fillable = [
        'e_name',
        'e_description',
        'e_start_date',
        'e_end_date',
        'e_degree',
        'ed_u_id', // FK ไปยัง users
    ];
    protected $casts = [
        'e_start_date' => 'date',
        'e_end_date' => 'date',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'ed_u_id');
    }
}
