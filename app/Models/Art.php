<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Auth;

class Art extends Model
{
    use HasFactory;

    protected $table = 'ART';
    protected $primaryKey = 'ART_ID';
    protected $fillable = ['USER_ID', 'ART_TITLE', 'DESCRIPTION', 'WIDTH', 'HEIGHT', 'UNIT', 'VIEW', 'IS_SALE', 'PRICE','IS_VERIF'];

    public function addView()
    {
        $now = $this->VIEW;
        $this->VIEW = $now+1;
        $this->save();
    }

    public function getStatus()
    {
        if($this->IS_VERIF == 1) {
            return 'VERIFIED';
        }
        else
        {
            return 'REJECTED';
        } 
    }

    public function isLiked()
    {
        $user = Auth::user();
        if (ArtLike::where('ART_ID',$this->ART_ID)->where('USER_ID',$user->USER_ID)->count() > 0) {
            return true;
        } else {
            return false;
        }
    }
    
    public function MasterUser(): BelongsTo
    {
        return $this->belongsTo(MasterUser::class, 'USER_ID', 'USER_ID');
    }

    public function ArtCategories(): HasMany
    {
        return $this->hasMany(ArtCategory::class, 'ART_ID', 'ART_ID');
    }

    public function ArtLikes(): HasMany
    {
        return $this->hasMany(ArtLike::class, 'ART_ID', 'ART_ID');
    }

    public function ArtImages(): HasMany
    {
        return $this->hasMany(ArtImage::class, 'ART_ID', 'ART_ID');
    }

    public function ArtCollection(): HasOne
    {
        return $this->hasOne(ArtCollection::class, 'ART_ID', 'ART_ID');
    }

    public function Carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'ART_ID', 'ART_ID');
    }

    public function OrderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'ART_ID', 'ART_ID');
    }

    public function isInStock()
    {
        if($this->OrderItems->count() > 0) {
            return false;
        } else {
            return true;
        }
    }
}
