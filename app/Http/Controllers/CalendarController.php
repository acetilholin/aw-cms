<?php

namespace App\Http\Controllers;

use App\Calendar;
use App\Reservation;
use App\Season;
use App\Setting;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function store(Request $request)
    {
        $validator = $this->calendarValidator($request);
        $validatedData = $validator->validate();

        $validatedData['price'] = $this->normalizePrice($validatedData['price'] ?? null);

        Calendar::create($validatedData);

        return view('reservation', $this->viewData(trans('messages.calendarIsAdded')));
    }

    public function edit(Request $request)
    {
        $id = $request->id;
        $calendar = Calendar::find($id);
        return response()->json([
            'calendar' => $calendar
        ], 200);
    }

    public function update(Request $request)
    {
        $id = $request->input('id');
        $validator = $this->calendarValidator($request, $id);
        $validatedData = $validator->validate();

        $validatedData['price'] = $this->normalizePrice($validatedData['price'] ?? null);

        Calendar::where('id', $id)->update($validatedData);

        return view('reservation', $this->viewData(trans('messages.calendarIsUpdated')));
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        Calendar::find($id)->delete();

        return view('reservation', $this->viewData(trans('messages.calendarIsDeleted')));
    }

    private function calendarValidator(Request $request, $excludeId = null)
    {
        $validator = validator($request->all(), [
            'season_id' => 'required|exists:seasons,id',
            'date_from' => 'required|date',
            'date_to' => 'required|date|after_or_equal:date_from',
            'price' => $this->priceRule(),
        ]);

        $validator->after(function ($validator) use ($request, $excludeId) {
            $dateFrom = $request->input('date_from');
            $dateTo = $request->input('date_to');

            if ($dateFrom && $dateTo && $this->datesOverlap($dateFrom, $dateTo, $excludeId)) {
                $validator->errors()->add('date_from', trans('messages.calendarDatesOverlap', [
                    'dateFrom' => date('d-m-Y', strtotime($dateFrom)),
                    'dateTo' => date('d-m-Y', strtotime($dateTo)),
                ]));
            }
        });

        return $validator;
    }

    private function datesOverlap($dateFrom, $dateTo, $excludeId = null)
    {
        return Calendar::where('date_from', '<=', $dateTo)
            ->where('date_to', '>=', $dateFrom)
            ->when($excludeId, function ($query) use ($excludeId) {
                $query->where('id', '!=', $excludeId);
            })
            ->exists();
    }

    private function normalizePrice($price)
    {
        return ($price === null || $price === '') ? 0 : $price;
    }

    private function priceRule()
    {
        $noRentalIds = Season::where('type', 4)->pluck('id')->implode(',');

        return ['nullable', 'numeric', 'required_unless:season_id,' . $noRentalIds];
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
