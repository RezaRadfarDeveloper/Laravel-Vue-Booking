<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Str;

class Booking extends Model
{
    use HasFactory;

    protected $fillable = ['from', 'to'];

    public function bookable() {

      return  $this->belongsTo(Bookable::class);

    }

    public function review() {

        return $this->hasOne(Review::class);

    }

    public function address() {

      return $this->belongsTo(Address::class);
    }

    public function scopeDatesBetween($query, $from, $to) {

        return   $query->where('to', '>=',$from)
            ->where('from','<=', $to);

    }

    public static function findByReviewkey(String $reviewKey): ?Booking
    {
        return static::where('review_key', $reviewKey)->with('bookable')->get()->first();
    }

    public static function boot()
    {
        parent::boot(); // TODO: Change the autogenerated stub
        static::creating(function ($booking) {
            $booking->review_key = Str::uuid();
        });
    }
}
