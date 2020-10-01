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

        if (url()->current() === env('APP_URL').'/en') {
            $view = $engView;
        } else {
            $view = $sloView;
        }

        return view($view, [
            'cars' => $cars
        ]);
    }
}
