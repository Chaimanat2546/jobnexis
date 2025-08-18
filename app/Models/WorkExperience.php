<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// WorkExperience.php
class WorkExperience extends Model
{
    protected $primaryKey = 'we_id';
    protected $fillable = ['we_company_name', 'we_position', 'we_start_date', 'we_end_date', 'we_amount', 'we_u_duties', 'we_u_id'];

    public function user()
    {
        return $this->belongsTo(User::class, 'we_u_id');
    }
}
