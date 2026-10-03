<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Reservation;
use App\Season;
use App\Setting;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function index() {
        return view('reservation', $this->viewData());
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $reservation = Reservation::find($id);
        return response()->json([
            'reservation' => $reservation
        ], 200);
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $validator = validator($request->all(), [
            'fullname' => 'required|min:5',
            'email' => 'required|email',
            'phone' => 'required|min:6',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'days' => 'required|integer|min:1',
            'price' => 'required|numeric',
            'message' => 'nullable|string|max:2000',
            'extras' => 'nullable|string|max:255',
        ]);

        $validator->after(function ($validator) use ($request, $id) {
            $dateFrom = $request->input('date_from');
            $dateTo = $request->input('date_to');

            if ($dateFrom && $dateTo && $this->datesOverlap($dateFrom, $dateTo, $id)) {
                $validator->errors()->add('date_from', trans('messages.reservationDatesOverlap', [
                    'dateFrom' => date('d-m-Y', strtotime($dateFrom)),
                    'dateTo' => date('d-m-Y', strtotime($dateTo)),
                ]));
            }
        });

        $validatedData = $validator->validate();

        Reservation::where('id', $id)->update($validatedData);

        return view('reservation', $this->viewData(trans('messages.reservationIsUpdated')));
    }

    private function datesOverlap($dateFrom, $dateTo, $excludeId)
    {
        return Reservation::where('date_from', '<=', $dateTo)
            ->where('date_to', '>=', $dateFrom)
            ->where('id', '!=', $excludeId)
            ->exists();
    }

    public function toggleCamper(Request $request)
    {
        $enabled = filter_var($request->input('enabled'), FILTER_VALIDATE_BOOLEAN);
        Setting::write('camper_enabled', $enabled ? '1' : '0');

        return response()->json(['enabled' => $enabled]);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        Reservation::find($id)->delete();

        return view('reservation', $this->viewData(trans('messages.reservationIsDeleted')));
    }

    private function viewData($info = null)
    {
        return [
            'reservations' => Reservation::orderBy('created_at', 'desc')->get(),
            'calendars' => Calendar::with('season')->orderBy('date_from')->get(),
            'seasons' => Season::orderBy('type')->get(),
            'extrasOptions' => config('extras'),
            'camperEnabled' => Setting::camperEnabled(),
            'info' => $info
        ];
    }
}
