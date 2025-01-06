<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HireQuestionReply extends Model
{
    use HasFactory;

    protected $table = 'HIRE_QUESTION_REPLY';
    protected $primaryKey = 'HIRE_QUESTION_REPLY_ID';
    protected $fillable = ['USER_ID', 'HIRE_QUESTION_ID', 'REPLY'];

    public function MasterUser(): BelongsTo
    {
        return $this->belongsTo(MasterUser::class, 'USER_ID', 'USER_ID');
    }

    public function HireQuestion(): BelongsTo
    {
        return $this->belongsTo(HireQuestion::class, 'HIRE_QUESTION_ID', 'HIRE_QUESTION_ID');
    }
}
