<?php

namespace App\Http\Controllers;

use App\Cars;
use Illuminate\Http\Request;

class WelcomePageController extends Controller
{
    function index(Request $request)
    {
        $cars = new Cars();
        $allCars = $cars->getAll();

        return view('welcome', [
            'cars' => $allCars
        ]);
    }

    function indexEN(Request $request)
    {
        $cars = new Cars();
        $allCars = $cars->getAll();

        return view('english', [
            'cars' => $allCars
        ]);
    }
}
