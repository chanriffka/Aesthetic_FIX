<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtLike extends Model
{
    use HasFactory;
    protected $table = 'ART_LIKE';
    protected $primaryKey = 'ART_LIKE_ID';
    protected $fillable = ['USER_ID', 'ART_ID'];

    public function Art(): BelongsTo
    {
        return $this->belongsTo(Art::class, 'ART_ID', 'ART_ID');
    }

    public function MasterUser(): BelongsTo
    {
        return $this->belongsTo(MasterUser::class, 'USER_ID', 'USER_ID');
    }
}
