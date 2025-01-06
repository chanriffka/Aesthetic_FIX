<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'ORDER';
    protected $primaryKey = 'ORDER_ID';
    protected $fillable = ['USER_ID', 'PAYMENT','FULLNAME', 'PHONE', 'ADDRESS', 'PROVINCE', 'CITY', 'POSTAL_CODE','STATUS'];

    // STATUS
    // 1 = NEW
    // 2 = PAID
    // 3 = IN DELIVERY
    // 3 = DELIVERED

    public function getStatusTextAttribute()
    {
        $statuses = [
            0 => 'CANCELED',
            1 => 'NEW',
            2 => 'PAID',
            3 => 'PACKED',
            4 => 'SHIPPED',
            5 => 'DELIVERED',
        ];

        return $statuses[$this->STATUS] ?? 'UNKNOWN';
    }

    public function getStatusColorAttribute()
    {
        $statuses = [
            0 => 'red',
            1 => 'blue',
            2 => 'purple',
            3 => 'orange',
            4 => 'pink',
            5 => 'green',
        ];

        return $statuses[$this->STATUS] ?? 'UNKNOWN';
    }

    public function getTotalPriceAttribute()
    {
        $subtotal = $this->orderItems->sum('PRICE_PER_ITEM');
        $total = $subtotal + 50000;
        return $total;
    }

    public function MasterUser(): BelongsTo
    {
        return $this->belongsTo(MasterUser::class, 'USER_ID', 'USER_ID');
    }

    public function OrderItems(): hasMany
    {
        return $this->hasMany(OrderItem::class, 'ORDER_ID', 'ORDER_ID');
    }
}
