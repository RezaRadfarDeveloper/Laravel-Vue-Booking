<?php

namespace Database\Seeders;

use App\Models\Bookable;
use App\Models\Booking;
use Illuminate\Database\Seeder;

class BookingsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        Bookable::all()->each(function (Bookable $bookable) {
            $booking = Booking::factory()->make();
//            dd($booking->to);
            $bookings   = collect([$booking]);

            for($i=0; $i <random_int(1,20);$i++) {
                $from = (clone $booking->to)->addDays(random_int(1,14));
//                echo $from;
                $to = (clone $from)->addDays(random_int(0,14));
//                echo $to;
//                die;
                $booking = Booking::make([
                    'from' => $from,
                    'to' => $to,
                    'price' => random_int(200,5000)
                ]);
            $bookings->push($booking);
//            echo $bookings[0]['from'];
            }
//        dd($bookings->first());
            $bookable->bookings()->saveMany($bookings);
        });


    }
}
