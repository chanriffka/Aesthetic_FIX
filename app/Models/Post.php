<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\hasMany;
use Illuminate\Support\Facades\Auth;

class Post extends Model
{
    use HasFactory;
    protected $table = 'POST';
    protected $primaryKey = 'POST_ID';
    protected $fillable = ['ARTIST_ID', 'CONTENT'];

    public function Artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class, 'ARTIST_ID', 'ARTIST_ID');
    }

    public function PostLikes(): HasMany
    {
        return $this->hasMany(PostLike::class, 'POST_ID', 'POST_ID');
    }

    public function PostComments(): HasMany
    {
        return $this->hasMany(PostComment::class, 'POST_ID', 'POST_ID');
    }

    public function PostMedias(): HasMany
    {
        return $this->hasMany(PostMedia::class, 'POST_ID', 'POST_ID');
    }

    public function isLiked()
    {
        $user = Auth::user();
        if (PostLike::where('POST_ID',$this->POST_ID)->where('USER_ID',$user->USER_ID)->count() > 0) {
            return true;
        } else {
            return false;
        }
    }
}
