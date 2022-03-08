<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Bookable;
use App\Models\Booking;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
       $data_first =  $request->validate([
           'bookings'=>'required|array|min:1',
            'bookings.*.bookable_id' =>'required|exists:bookables,id',
            'bookings.*.from' => 'required|date|after_or_equal:today',
            'bookings.*.to' => 'required|date|after_or_equal:bookings.*.from',
            'customer.first_name' => "required|min:2",
            'customer.last_name' => "required|min:2",
            'customer.street' => "required|min:2",
            'customer.zip' => "required|min:2",
            'customer.country' => "required|min:3",
            'customer.city' => "required|min:2",
            'customer.email' => "required|email",
            'customer.state' => "required|min:2",
        ]);

       $data_second = $request->validate([
           'bookings.*' => ['required', function($attribute,$value,$fail){
               $bookable = Bookable::findOrfail($value['bookable_id']);

               if(!$bookable->availableFor($value['from'],$value['to'])) {
                   $fail('the object is not available for given period');
               }
           }]
       ]);

    $data = array_merge($data_first,$data_second);
    $dataBookings = $data['bookings'];
    $dataAddress = $data['customer'];

    $bookings = collect($dataBookings)->map(function($bookingData) use ($dataAddress) {
            $bookable = Bookable::findOrfail($bookingData['bookable_id']);
            $booking = new Booking();
            $booking->from = $bookingData['from'];
            $booking->to = $bookingData['to'];
            $booking->price = ($bookable->priceFor($bookingData['from'],$bookingData['to']))['total'];
            $booking->bookable()->associate($bookable);

            $booking->address()->associate(Address::create($dataAddress));
            $booking->save();

            return $booking;
    });
    return $bookings;
    }
}
