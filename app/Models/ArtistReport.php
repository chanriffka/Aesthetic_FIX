<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ArtistReport extends Model
{
    use HasFactory;
    protected $table = 'ARTIST_REPORT';
    protected $primaryKey = 'ARTIST_REPORT_ID';
    protected $fillable = ['ARTIST_ID', 'USER_ID', 'USER_RATING', 'CONTENT', 'STATUS'];

    public function Artist()
    {
        return $this->belongsTo(Artist::class, 'ARTIST_ID', 'ARTIST_ID');
    }

    public function MasterUser(): BelongsTo
    {
        return $this->belongsTo(MasterUser::class, 'USER_ID', 'USER_ID');
    }

    public function getStatus()
    {
        if($this->STATUS == 0) {
            return 'NEW';
        } elseif ($this->STATUS == 1) {
            return 'REVIEWED';
        } else {
            return 'UNKNOWN';
        }
    }

    public function getStatusColor()
    {
        if($this->STATUS == 0) {
            return 'blue';
        } elseif ($this->STATUS == 1) {
            return 'green';
        } else {
            return 'grey';
        }
    }

    public function getNextAction()
    {
        if($this->STATUS == 0) {
            return 'Mark as reviewed';
        } elseif ($this->STATUS == 1) {
            return 'Mark as new';
        } else {
            return 'Unknown';
        }
    }
}
