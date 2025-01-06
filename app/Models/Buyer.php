<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Buyer extends Model
{
    use HasFactory;
    protected $table = 'BUYER';
    protected $primaryKey = 'BUYER_ID';
    protected $fillable=[
        'USER_ID',
        'FULLNAME',
        'PHONE_NUMBER',
        'WISHLIST',
        'FOLLOWEDARTIST',
        'ADDRESS',
        'IS_ACTIVE'
    ];

    public function MasterUser():BelongsTo
    {
        return $this->belongsTo(MasterUser::class, 'USER_ID', 'USER_ID');
    }

    public function isActive()
    {
        if($this->IS_ACTIVE == 1) {
            return true;
        } else {
            return false;
        }
    }
}
