<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

// Education.php
class Education extends Model
{
    protected $table = 'educations';
    protected $primaryKey = 'ed_id';
    protected $fillable = ['ed_name', 'ed_start_date', 'ed_end_date', 'ed_degree', 'ed_u_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'ed_u_id');
    }
}

