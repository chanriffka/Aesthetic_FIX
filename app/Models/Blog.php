<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Blog extends Model
{
    use HasFactory;

    protected $table = 'BLOG';
    protected $primaryKey = 'BLOG_ID';
    protected $fillable = ['USER_ID', 'TITLE', 'SLUG', 'CONTENT', 'IMAGE_PATH', 'VIEW'];

    public function MasterUser(): BelongsTo
    {
        return $this->belongsTo(MasterUser::class, 'USER_ID', 'USER_ID');
    }
}
