<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use Spatie\Permission\Models\Role;


class User extends Authenticatable implements MustVerifyEmail
{

    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'status',
        'role',
        'image',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'first_login_at' => 'datetime',
        'last_login_at' => 'datetime',
        'last_course_login_at' => 'datetime',
    ];

    public function hasVerifiedEmail(): bool
    {
        if ($this->hasRole('admin')) {
            return true;
        }

        if ($this->status === 'active') {
            return true;
        }

        return $this->email_verified_at !== null;
    }

    public function roleName(){
        return $this->getRoleNames()->first();
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class)->withPivot(['working_time', 'result', 'is_completed', 'progress'])->withTimestamps();
    }
}
