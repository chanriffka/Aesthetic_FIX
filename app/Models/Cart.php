<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $table = 'CART';
    protected $primaryKey = 'CART_ID';
    protected $fillable = ['USER_ID', 'ART_ID', 'QUANTITY'];

    public function MasterUser(): BelongsTo
    {
        return $this->belongsTo(MasterUser::class, 'USER_ID', 'USER_ID');
    }

    public function Art(): BelongsTo
    {
        return $this->belongsTo(Art::class, 'ART_ID', 'ART_ID');
    }
}
