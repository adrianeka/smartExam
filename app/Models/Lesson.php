<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    protected $fillable = ['module_id', 'title', 'content', 'video_url', 'document_path', 'order_index', 'is_published'];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }
}
