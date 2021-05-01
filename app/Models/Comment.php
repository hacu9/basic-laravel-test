<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'content',
        'is_published',
        'user_id',
        'post_id',
    ];

    protected $post = [
        'is_published' => 'boolean'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function posts()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Scope a query to filter posts by publishStatus.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  boolean  $status
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePublishedStatus($query, $status)
    {
        return $query->where('is_published', $status);
    }
}
