<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtCollection extends Model
{
    use HasFactory;
    protected $table = 'ART_COLLECTION';
    protected $primaryKey = 'ART_COLLECTION_ID';
    protected $fillable = ['ARTIST_COLLECTION_ID', 'ART_ID'];

    public function Art(): BelongsTo
    {
        return $this->belongsTo(Art::class, 'ART_ID', 'ART_ID');
    }

    public function ArtistCollection(): BelongsTo
    {
        return $this->belongsTo(Art::class, 'ARTIST_COLLECTION_ID', 'ARTIST_COLLECTION_ID');
    }
}
