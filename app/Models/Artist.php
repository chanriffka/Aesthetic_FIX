<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Artist extends Model
{
    use HasFactory;
    protected $table = 'ARTIST';
    protected $primaryKey = 'ARTIST_ID';
    protected $fillable = ['USER_ID', 'LOCATION','ROLE','BIO','ABOUT','X','PINTEREST','INSTAGRAM','LINKEDIN','IS_ACTIVE','VIEW'];

    public function isActive()
    {
        if($this->IS_ACTIVE == 1) {
            return true;
        } else {
            return false;
        }
    }
    
    public function addView()
    {
        $now = $this->VIEW;
        $this->VIEW = $now+1;
        $this->save();
    }

    public function MasterUser()
    {
        return $this->belongsTo(MasterUser::class, 'USER_ID', 'USER_ID');
    }

    public function ArtistRatings(): HasMany
    {
        return $this->hasMany(ArtistRating::class, 'ARTIST_ID', 'ARTIST_ID');
    }

    public function ArtistReports(): HasMany
    {
        return $this->hasMany(ArtistReport::class, 'ARTIST_ID', 'ARTIST_ID');
    }
    
    public function ArtistSkills(): HasMany
    {
        return $this->hasMany(ArtistSkill::class, 'ARTIST_ID', 'ARTIST_ID');
    }

    public function getAverageArtistRatingAttribute()
    {
        $totalRating = 0;
        $ratings = $this->ArtistRatings;
        foreach($ratings as $rating) {
            $totalRating += $rating->USER_RATING;
        }

        if(count($ratings) > 0) {
            return $totalRating/count($ratings);
        } else {
            return 0;
        }
    }

    public function Collections(): HasMany
    {
        return $this->hasMany(ArtistCollection::class, 'ARTIST_ID', 'ARTIST_ID');
    }

    public function Posts(): HasMany
    {
        return $this->hasMany(Post::class, 'ARTIST_ID', 'ARTIST_ID');
    }

    public function ArtistHire(): HasOne
    {
        return $this->hasOne(ArtistHire::class, 'ARTIST_ID', 'ARTIST_ID');
    }
}
