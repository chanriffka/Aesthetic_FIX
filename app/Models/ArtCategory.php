<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtCategory extends Model
{
    use HasFactory;
    protected $table = 'ART_CATEGORY';
    protected $primaryKey = 'ART_CATEGORY_ID';
    protected $fillable = ['ART_ID', 'ART_CATEGORY_MASTER_ID'];

    public function Art(): BelongsTo
    {
        return $this->belongsTo(Art::class, 'ART_ID', 'ART_ID');
    }

    public function ArtCategoryMaster(): BelongsTo
    {
        return $this->belongsTo(ArtCategoryMaster::class, 'ART_CATEGORY_MASTER_ID', 'ART_CATEGORY_MASTER_ID');
    }
}
