<?php

namespace App\Helpers;

use App\Calendar;
use App\Reservation;

class CamperAvailabilityHelper
{
    public function getCalendar()
    {
        return Calendar::with('season:id,type')
            ->orderBy('date_from')
            ->get(['id', 'season_id', 'date_from', 'date_to', 'price'])
            ->map(function ($calendar) {
                return [
                    'date_from' => $calendar->date_from,
                    'date_to' => $calendar->date_to,
                    'price' => (float) $calendar->price,
                    'type' => $calendar->season->type,
                ];
            });
    }

    // Only future/current bookings matter for blocking new selections - past days are already disabled.
    // Select only the date range, never customer details (name/email/phone/message), since this ships to the public page.
    public function getReservations()
    {
        return Reservation::where('date_to', '>=', now()->toDateString())
            ->get(['date_from', 'date_to']);
    }
}
