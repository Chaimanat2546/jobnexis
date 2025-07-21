<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificates extends Model
{
    use HasFactory;
    protected $primaryKey = 'cer_id';
    protected $fillable = [
        'cer_name',
        'cer_image',
        'cer_u_id',
        'cer_c_id',
        'cer_publiced',
    ];
    protected $casts = [
        'cer_publiced' => 'boolean',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'cer_u_id');
    }
    public function course()
    {
        return $this->belongsTo(Course::class, 'cer_c_id');
    }
}
