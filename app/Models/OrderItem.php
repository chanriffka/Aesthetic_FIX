<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $table = 'ORDER_ITEM';
    protected $primaryKey = 'ORDER_ITEM_ID';
    protected $fillable = ['ORDER_ID', 'ART_ID', 'QUANTITY','PRICE_PER_ITEM'];

    public function Order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'ORDER_ID', 'ORDER_ID');
    }

    public function Art(): BelongsTo
    {
        return $this->belongsTo(Art::class, 'ART_ID', 'ART_ID');
    }
}
