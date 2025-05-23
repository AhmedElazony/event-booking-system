<?php

namespace App\Http\Controllers\Api\V1;

use Api\Support\Http\Controllers\ApiController;
use App\Http\Resources\BookingResource;
use App\Models\Event;

class BookingController extends ApiController
{
    public function store(Event $event)
    {
        $user = auth()->user();
        if ($user->isAdmin() || $user->isSuperAdmin()) {
            return $this->error('You cannot book an event as an admin');
        }
        if ($event->bookedByUser($user->id)) {
            return $this->error('You have already booked this event');
        }

        $booking = $user->bookings()->create([
            'event_id' => $event->id,
            'total_price' => $event->price,
        ]);
        return $this->success([
            'message' => 'Booking created successfully',
            'booking' => BookingResource::make($booking->load(['event', 'user'])),
        ]);
    }

    public function index()
    {
        $user = request()->user();
        return $this->success(
            BookingResource::collection(
                $user->bookings()
                    ->with(['event.category', 'event.tags', 'user'])
                    ->latest()
                    ->get()
            ),
        );
    }
}
