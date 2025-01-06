<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArtistCollection extends Model
{
    use HasFactory;
    protected $table = 'ARTIST_COLLECTION';
    protected $primaryKey = 'ARTIST_COLLECTION_ID';
    protected $fillable = ['COLLECTION_NAME', 'COLLECTION_DESCR','ARTIST_ID'];

    public function Artist(): BelongsTo
    {
        return $this->belongsTo(Artist::class, 'ARTIST_ID', 'ARTIST_ID');
    }

    public function ArtistCollections(): HasMany
    {
        return $this->hasMany(ArtCollection::class, 'ARTIST_COLLECTION_ID', 'ARTIST_COLLECTION_ID');
    }
}
