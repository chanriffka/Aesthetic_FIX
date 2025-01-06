<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostComment extends Model
{
    use HasFactory;

    protected $table = 'POST_COMMENT';
    protected $primaryKey = 'POST_COMMENT_ID';
    protected $fillable = ['POST_ID', 'USER_ID', 'CONTENT'];

    public function Post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'POST_ID', 'POST_ID');
    }

    public function MasterUser(): BelongsTo
    {
        return $this->belongsTo(MasterUser::class, 'USER_ID', 'USER_ID');
    }
}
