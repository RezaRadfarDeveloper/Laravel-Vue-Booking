<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    use HasFactory;
    public $fillable = ['id','content','rating'];

    public $incrementing = false;

    protected $keyType = 'string';

    public function bookable() {
        return $this->belongsTo(Bookable::class);
    }

    public function booking() {
        return $this->belongsTo(Booking::class);
    }
}
