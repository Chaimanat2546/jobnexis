<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\UserProfile;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function isAdmin()
    {
        return $this->role === 'admin';
    }

    public function isEducation()
    {
        return $this->role === 'education';
    }
    public function isProvider()
    {
        return $this->role === 'provider';
    }
    public function isJobber()
    {
        return $this->role === 'jobber';
    }
    // Relationship: User -> UserProfile (One to One)
    public function userProfile()
    {
        return $this->hasOne(UserProfile::class, 'up_u_id');
    }
    public function courseMembers()
    {
        return $this->hasMany(CourseMember::class, 'cm_u_id');
    }
    public function educations()
    {
        return $this->hasMany(Education::class, 'ed_u_id');
    }
    public function workExpreriences()
    {
        return $this->hasMany(WorkExperiences::class, 'we_u_id');
    }
    public function recruitment()
    {
        return $this->hasMany(Recruitment::class, 'rc_user_id');
    }
    public function user()
    {
        return $this->belongsTo(CompaniesProfile::class, 'co_user_id');
    }
    public function Certificate()
    {
        return $this->hasMany(Certificates::class, 'cer_u_id');
    }
}
