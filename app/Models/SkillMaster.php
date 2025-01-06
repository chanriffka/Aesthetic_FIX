<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SkillMaster extends Model
{
    use HasFactory;

    protected $table = 'SKILL_MASTER';
    protected $primaryKey = 'SKILL_MASTER_ID';
    protected $fillable = ['DESCR'];

    public function ArtistSkills(): HasMany
    {
        return $this->hasMany(ArtistSkill::class, 'SKILL_MASTER_ID', 'SKILL_MASTER_ID');
    }
}
