<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;
    protected $primaryKey = 'ed_id';
    protected $table = 'educations';
    protected $fillable = [
        'ed_name',
        'ed_description',
        'ed_start_date',
        'ed_end_date',
        'ed_degree',
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
