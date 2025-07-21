<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkExperiences extends Model
{
    use HasFactory;
    protected $primaryKey = 'we_id';
    protected $fillable = [
        'we_company_name',
        'we_position',
        'we_start_date',
        'we_end_date',
        'w_amount',
        'we_u_duties',
        'we_u_id',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'we_u_id');
    }
}
