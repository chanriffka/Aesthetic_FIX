<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostMedia extends Model
{
    use HasFactory;
    protected $table = 'POST_MEDIA';
    protected $primaryKey = 'POST_MEDIA_ID';
    protected $fillable = ['POST_ID', 'POST_MEDIA_PATH'];

    public function Post(): BelongsTo
    {
        return $this->belongsTo(Post::class, 'POST_ID', 'POST_ID');
    }
}
