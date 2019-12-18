<?php

namespace App\Http\Controllers;

use App\Cars;
use Illuminate\Http\Request;

class WelcomePageController extends Controller
{
    function index(Request $request)
    {
        $cars = new Cars();
        $allCars = $cars->getAllFirstPage();

        return view('welcome', [
            'cars' => $allCars
        ]);
    }

    function indexEN(Request $request)
    {
        $cars = new Cars();
        $allCars = $cars->getAllFirstPage();

        return view('english', [
            'cars' => $allCars
        ]);
    }

    function indexTest(Request $request)
    {
        $cars = new Cars();
        $allCars = $cars->getAllFirstPage();

        return view('test', [
            'cars' => $allCars
        ]);
    }

    function indexTest2(Request $request)
    {
        $cars = new Cars();
        $allCars = $cars->getAllFirstPage();

        return view('test2', [
            'cars' => $allCars
        ]);
    }
}
