<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Analytics\Period;


class StatisticsController extends Controller
{
    function index()
    {
        if (Auth::guest()) {
            return redirect('/login');
        }

        $days = 30;
        $substractDays = 30;
        $today = date("d.m.Y");
        $data = \Analytics::fetchTotalVisitorsAndPageViews(Period::days($days));

        foreach ($data as $dt) {
            $visitors[] = $dt['visitors'];
            $dates[] = date('d.m', (strtotime("-$substractDays day", strtotime($today))));
            $substractDays--;
        }
        return view('statistics', [
            'visitors' => $visitors,
            'dates' => $dates,
            'days' => $days
        ]);
    }

    function getData(Request $request)
    {
        $dateFrom = $request->datefrom;
        $dateTo = $request->dateto;
        $days = round((strtotime($dateTo) - strtotime($dateFrom)) / (60 * 60 * 24));

        $substractDays = $days;
        $today = date("d.m.Y");
        $data = \Analytics::fetchTotalVisitorsAndPageViews(Period::days($days));

        foreach ($data as $dt) {
            $visitors[] = $dt['visitors'];
            $dates[] = date('d.m', (strtotime("-$substractDays day", strtotime($today))));
            $substractDays--;
        }
        return $data = [
            'visitors' => $visitors,
            'dates' => $dates,
            'days' => $days+1
        ];
    }
}
