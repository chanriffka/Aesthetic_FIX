<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    protected $table = 'ADDRESS';
    protected $primaryKey = 'ADDRESS_ID';
    protected $fillable = ['USER_ID', 'FULLNAME', 'PHONE', 'ADDRESS', 'PROVINCE', 'CITY', 'POSTAL_CODE', 'IS_ACTIVE'];

    public function MasterUser(): BelongsTo
    {
        return $this->belongsTo(MasterUser::class, 'USER_ID', 'USER_ID');
    }
}
