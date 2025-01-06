<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactUs extends Model
{
    use HasFactory;

    protected $table = 'CONTACT_US';
    protected $primaryKey = 'CONTACT_US_ID';
    protected $fillable = ['FULLNAME', 'EMAIL', 'PHONE_NUMBER', 'MESSAGE'];

    public function getStatusTextAttribute()
    {
        $statuses = [
            0 => 'CONTACT',
            1 => 'SOLVED',
        ];

        return $statuses[$this->STATUS] ?? 'UNKNOWN';
    }

    public function getStatusColorAttribute()
    {
        $statuses = [
            0 => 'blue',
            1 => 'green'
        ];

        return $statuses[$this->STATUS] ?? 'grey';
    }
}
