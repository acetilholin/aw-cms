<?php

namespace App\Http\Controllers;

use App\Car;
use App\Helpers\CamperAvailabilityHelper;
use App\Setting;
use Illuminate\Http\Request;

class WelcomePageController extends Controller
{
    function index(Request $request)
    {
        $cars = Car::where('hidden', 0)
            ->orderBy('new', 'DESC')
            ->orderBy('created_at', 'DESC')
            ->get();

        $sloView = 'welcome';
        $engView = 'english';

        $helper = new CamperAvailabilityHelper();
        $calendars = $helper->getCalendar();
        $reservations = $helper->getReservations();

        $view = url()->current() === env('APP_URL').'/en' ? $engView : $sloView;
        $route = url()->current() === env('APP_URL') ? 'english' : 'welcome';

        return view($view, [
            'cars' => $cars,
            'calendars' => $calendars,
            'reservations' => $reservations,
            'extrasOptions' => config('extras'),
            'camperEnabled' => Setting::camperEnabled(),
            'langRoute' => $route,
            'lang' => $view === 'welcome' ? 'ENG' : 'SLO'
        ]);
    }

    function camperAvailability()
    {
        $helper = new CamperAvailabilityHelper();

        return response()->json([
            'calendar' => $helper->getCalendar(),
            'reservations' => $helper->getReservations()
        ]);
    }
}
