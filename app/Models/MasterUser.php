<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\MasterUser as Authenticatable;

class MasterUser extends Authenticatable
{
    use HasFactory;
    protected $table = 'MASTER_USER';
    protected $primaryKey = 'USER_ID';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable=[
        'USERNAME',
        'EMAIL',
        'PASSWORD',
        'USER_LEVEL',
        'IS_ACTIVE'
    ];

    public function Followings(): HasMany
    {
        return $this->hasMany(Follower::class, 'FOLLOWER_USER_ID', 'USER_ID');
    }

    public function getTotalPurchasedItemAttribute()
    {
        $total = 0;
        foreach($this->Orders as $order) {
            foreach($order->OrderItems as $item) {
                $total += $item->QUANTITY;
            }
        }
        return $total;
    }

    public function getTotalSpendAttribute()
    {
        $total = 0;
        foreach($this->Orders as $order) {
            foreach($order->OrderItems as $item) {
                $total += ($item->QUANTITY * $item->PRICE_PER_ITEM);
            }
        }
        return $total;
    }

    public function getTotalArtViewAttribute()
    {
        $total = 0;
        foreach($this->Arts as $art) {
            $total += $art->VIEW;
        }
        return $total;
    }

    public function getTotalArtLikeAttribute()
    {
        $total = 0;
        foreach($this->Arts as $art) {
            $total += $art->ArtLikes->count();
        }
        return $total;
    }

    public function isFollowing($userId)
    {
        $data = $this->Followings->where('FOLLOWED_USER_ID',$userId)->first();
        if($data == null) {
            return false;
        } else {
            return true;
        }
    }

    public function Followers(): HasMany
    {
        return $this->hasMany(Follower::class, 'FOLLOWED_USER_ID', 'USER_ID');
    }

    public function Buyer():HasOne
    {
        return $this->hasOne(Buyer::class, 'USER_ID', 'USER_ID');
    }

    public function Artist():HasOne
    {
        return $this->hasOne(Artist::class, 'USER_ID', 'USER_ID');
    }

    public function ArtistRating(): HasMany
    {
        return $this->hasMany(ArtistRating::class, 'USER_ID', 'USER_ID');
    }

    public function ArtistReports(): HasMany
    {
        return $this->hasMany(ArtistReport::class, 'USER_ID', 'USER_ID');
    }

    public function Arts():HasMany
    {
        return $this->hasMany(Art::class, 'USER_ID', 'USER_ID');
    }

    public function Blogs():HasMany
    {
        return $this->hasMany(Blog::class, 'USER_ID', 'USER_ID');
    }

    public function ArtLikes():HasMany
    {
        return $this->hasMany(ArtLike::class, 'USER_ID', 'USER_ID');
    }

    public function PostLikes():HasMany
    {
        return $this->hasMany(PostLike::class, 'USER_ID', 'USER_ID');
    }

    public function PostComments():HasMany
    {
        return $this->hasMany(PostComment::class, 'USER_ID', 'USER_ID');
    }

    public function getAuthPassword()
    {
        return $this->PASSWORD;
    }

    public function Carts(): HasMany
    {
        return $this->hasMany(Cart::class, 'USER_ID', 'USER_ID');
    }

    public function Orders(): HasMany
    {
        return $this->hasMany(Order::class, 'USER_ID', 'USER_ID');
    }

    public function Addresses(): HasMany
    {
        return $this->hasMany(Address::class, 'USER_ID', 'USER_ID');
    }

    public function hireQuestions(): HasMany
    {
        return $this->hasMany(HireQuestion::class, 'USER_ID', 'USER_ID');
    }

    public function getTotalEarningAttribute()
    {
        return $this->Arts()->with('OrderItems')
        ->get()
        ->flatMap(function ($art) {
            return $art->OrderItems;
        })
        ->sum(function ($orderItem) {
            return $orderItem->QUANTITY * $orderItem->PRICE_PER_ITEM;
        });
    }

    public function getTotalEarningByMonth(int $month)
    {
        // Use the relationship to filter by month and sum up the total price
        return $this->Arts()->with(['OrderItems' => function ($query) use ($month) {
            $query->whereMonth('created_at', $month); // Filter by the given month
        }])
        ->get()
        ->flatMap(function ($art) {
            return $art->OrderItemss;
        })
        ->sum(function ($orderItem) {
            return $orderItem->QUANTITY * $orderItem->PRICE_PER_ITEM;
        });
    }

    public function getTotalEarningCurrentMonthAttribute()
    {
        $currentMonthStart = Carbon::now()->startOfMonth();
        $currentMonthEnd = Carbon::now()->endOfMonth();

        return $this->Arts()
            ->whereHas('OrderItems', function ($query) use ($currentMonthStart, $currentMonthEnd) {
                $query->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd]);
            })
            ->with(['OrderItems' => function ($query) use ($currentMonthStart, $currentMonthEnd) {
                $query->whereBetween('created_at', [$currentMonthStart, $currentMonthEnd]);
            }])
            ->get()
            ->flatMap(function ($art) {
                return $art->OrderItems;
            })
            ->sum(function ($orderItem) {
                return $orderItem->QUANTITY * $orderItem->PRICE_PER_ITEM;
            });
    }

    public function getSoldItems()
    {
        return OrderItem::whereHas('Art', function ($query) {
            $query->where('USER_ID', $this->USER_ID);
        })->get();
    }

    public function getYearSoldItems()
    {
        return OrderItem::whereHas('Art', function ($query) {
            $query->where('USER_ID', $this->USER_ID);
        })
        ->selectRaw('DATENAME(YEAR, created_at) AS YEAR_NAME')
        ->groupByRaw('DATENAME(YEAR, created_at), YEAR(created_at)')
        ->orderByRaw('YEAR(created_at)')
        ->get();
    }

    public function getTotalSpendingAttribute()
    {
        // Sum up the total price of all orders related to this user
        return $this->Orders()->with('OrderItems')->get()->sum(function ($order) {
            return $order->OrderItems->sum(function ($item) {
                return $item->QUANTITY * $item->PRICE_PER_ITEM;
            });
        });
    }

    // public function Artists()
    // {
    //     return $this->hasOne(Artist::class);
    // }

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'PASSWORD'
    ];
}
