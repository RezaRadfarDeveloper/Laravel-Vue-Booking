<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Bookable extends Model
{
    use HasFactory;

    public function bookings() {

   return $this->hasMany(Booking::class);

    }

    public  function reviews() {

        return $this->hasMany(Review::class);

    }

    public function availableFor($from, $to) {

   return  0 === $this->bookings()->datesBetween($from,$to)->count();
    }

    public function priceFor($from, $to) {
        $days = (new Carbon($from))->diffInDays(new Carbon($to)) + 1;
        $price = $this->price * $days;

        return  [
            'total' => $price,
            'breakdown' => [
                $this->price => $days
            ]
        ];
    }
}
