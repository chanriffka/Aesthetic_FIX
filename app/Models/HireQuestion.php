<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class HireQuestion extends Model
{
    use HasFactory;
    protected $table = 'HIRE_QUESTION';
    protected $primaryKey = 'HIRE_QUESTION_ID';
    protected $fillable = ['USER_ID', 'ARTIST_HIRE_ID', 'QUESTION'];

    public function MasterUser(): BelongsTo
    {
        return $this->belongsTo(MasterUser::class, 'USER_ID', 'USER_ID');
    }

    public function ArtistHire(): BelongsTo
    {
        return $this->belongsTo(ArtistHire::class, 'ARTIST_HIRE_ID', 'ARTIST_HIRE_ID');
    }

    public function HireQuestionReplies(): HasMany
    {
        return $this->hasMany(HireQuestionReply::class, 'HIRE_QUESTION_ID', 'HIRE_QUESTION_ID');
    }
}
