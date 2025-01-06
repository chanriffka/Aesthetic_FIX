<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtistSkill extends Model
{
    use HasFactory;

    protected $table = 'ARTIST_SKILL';
    protected $primaryKey = 'ARTIST_SKILL_ID';
    protected $fillable = ['ARTIST_ID', 'SKILL_MASTER_ID'];

    public function Artist(): BelongsTo
    {
        return $this->belongsTo(Art::class, 'ARTIST_ID', 'ARTIST_ID');
    }

    public function SkillMaster(): BelongsTo
    {
        return $this->belongsTo(SkillMaster::class, 'SKILL_MASTER_ID', 'SKILL_MASTER_ID');
    }
}
