<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtImage extends Model
{
    use HasFactory;
    protected $table = 'ART_IMAGE';
    protected $primaryKey = 'ART_IMAGE_ID';
    protected $fillable = ['ART_ID', 'IMAGE_PATH'];

    public function Art(): BelongsTo
    {
        return $this->belongsTo(Art::class, 'ART_ID', 'ART_ID');
    }
}
