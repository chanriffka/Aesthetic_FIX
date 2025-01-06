<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ArtCategoryMaster extends Model
{
    use HasFactory;

    protected $table = 'ART_CATEGORY_MASTER';
    protected $primaryKey = 'ART_CATEGORY_MASTER_ID';
    protected $fillable = ['DESCR'];

    public function ArtCategories(): HasMany
    {
        return $this->hasMany(ArtCategory::class, 'ART_CATEGORY_MASTER_ID', 'ART_CATEGORY_MASTER_ID');
    }
}
