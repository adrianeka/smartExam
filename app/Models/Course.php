<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'code', 'name', 'description', 'language', 'category', 'is_registered_allowed', 'is_unregistered_allowed', 'last_accessed_at',
        'department', 'department_url', 'template_course_id', 'is_demo_content', 'access_type', 'subscription_allowed', 'unsubscription_allowed',
        'storage_limit_mb', 'is_special_course', 'tags', 'video_url'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class)->withPivot(['working_time', 'result', 'is_completed', 'progress'])->withTimestamps();
    }
}
