<?php

namespace App\Http\Controllers;

use App\Car;
use Illuminate\Http\Request;

class WelcomePageController extends Controller
{
    function index(Request $request)
    {
        $cars = Car::where('hidden', 0)
            ->orderBy('new', 'DESC')
            ->get();

        $sloView = 'welcome';
        $engView = 'english';

        $view = url()->current() === env('APP_URL').'/en' ? $engView : $sloView;
        $route = url()->current() === env('APP_URL') ? 'english' : 'welcome';

        return view($view, [
            'cars' => $cars,
            'langRoute' => $route,
            'lang' => $view === 'welcome' ? 'ENG' : 'SLO'
        ]);
    }
}
