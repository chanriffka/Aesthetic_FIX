<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Follower extends Model
{
    use HasFactory;
    protected $table = 'FOLLOWER';
    protected $primaryKey = 'FOLLOWER_ID';
    protected $fillable=[
        'FOLLOWER_USER_ID',
        'FOLLOWED_USER_ID',
    ];

    public function Follower(): BelongsTo
    {
        return $this->belongsTo(MasterUser::class, 'FOLLOWER_USER_ID', 'USER_ID');
    }

    public function Followed(): BelongsTo
    {
        return $this->belongsTo(MasterUser::class, 'FOLLOWED_USER_ID', 'USER_ID');
    }
}
