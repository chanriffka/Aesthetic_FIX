<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtistRating extends Model
{
    use HasFactory;
    protected $table = 'ARTIST_RATING';
    protected $primaryKey = 'ARTIST_RATING_ID';
    protected $fillable = ['ARTIST_ID', 'USER_ID', 'USER_RATING', 'CONTENT','RATING_ID'];

    public function Artist()
    {
        return $this->belongsTo(Artist::class, 'ARTIST_ID', 'ARTIST_ID');
    }

    public function MasterUser(): BelongsTo
    {
        return $this->belongsTo(MasterUser::class, 'USER_ID', 'USER_ID');
    }
}
