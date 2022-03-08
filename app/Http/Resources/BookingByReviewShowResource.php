<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BookingByReviewShowResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
                'booking_id' => $this->id,
                'to' => $this->to,
                'from' => $this->from,
                'bookable' => new BookingByReviewBookableShowResource($this->bookable)
        ];
    }
}
