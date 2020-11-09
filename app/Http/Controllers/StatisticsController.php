<?php

namespace App\Http\Controllers;

use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Analytics\Period;


class StatisticsController extends Controller
{
    public $days = 30;

    function index()
    {
        $totalVisitors = 0;
        $days = $this->days;
        $substractDays = $this->days;
        $today = date("d.m.Y");
        $data = \Analytics::fetchTotalVisitorsAndPageViews(Period::days($days));

        foreach ($data as $dt) {
            $visitors[] = $dt['visitors'];
            $totalVisitors += $dt['visitors'];
            $dates[] = date('d.m', (strtotime("-$substractDays day", strtotime($today))));
            $substractDays--;
        }

        $liveUsers = $this->liveUsers();
        $average = round(($totalVisitors / $days), 1);

        return view('statistics', [
            'avg' => $average,
            'liveUsers' => $liveUsers['liveUsers'],
            'liveDetails' => $liveUsers['details'],
            'visitors' => $visitors,
            'totalVisitors' => $totalVisitors,
            'dates' => $dates,
            'days' => $days
        ]);
    }

    function liveUsers()
    {
        $liveUsers = 0;
        $viewId = env('ANALYTICS_VIEW_ID');
        $metrics = 'rt:activeUsers';
        $dimensions = ['dimensions' => 'rt:country,rt:deviceCategory'];
        $userData = \Analytics::getAnalyticsService()->data_realtime->get('ga:' . $viewId, $metrics, $dimensions)->rows;

        if (!empty($userData)) {
            foreach ($userData as $key => $data) {
                $details[] = $data;
                $liveUsers += $data[2];
            }

            $data = [
                'liveUsers' => $liveUsers,
                'details' => $details
            ];
        } else {
            $data = [
                'liveUsers' => 0,
                'details' => []
            ];
        }
        return $data;
    }

    function getCountries($days)
    {
        $metrics = 'ga:visits';
        $options = ['dimensions' => 'ga:country', 'sort' => '-ga:visits'];
        $array = \Analytics::performQuery(Period::days($days), $metrics, $options)->rows;
        if (count($array)) {
            foreach ($array as $k => $v) {
                $countriesTotal[$k] = $v[0];
                $countriesTotalNo[$k] = (int)$v[1];
            }
        }
        $data = [
            'countries' => $countriesTotal,
            'visitsPerCountry' => $countriesTotalNo
        ];
        return $data;
    }

    function getData(Request $request)
    {
        $dateFrom = $request->datefrom;
        $dateTo = $request->dateto;
        $substractDateTo = $request->dateto;
        $totalVisitors = 0;
        $days = round((strtotime($dateTo) - strtotime($dateFrom)) / (60 * 60 * 24));

        $dateFrom = DateTime::createFromFormat('d.m.Y', $dateFrom);
        $dateTo = DateTime::createFromFormat('d.m.Y', $dateTo);

        $substractDays = $days;
        $today = date("d.m.Y");
        $data = \Analytics::fetchTotalVisitorsAndPageViews(Period::create($dateFrom, $dateTo));

        foreach ($data as $dt) {
            $visitors[] = $dt['visitors'];
            $totalVisitors += $dt['visitors'];
            $dates[] = date('d.m', (strtotime("-$substractDays day", strtotime($substractDateTo))));
            $substractDays--;
        }

        $average = round(($totalVisitors / ($days + 1)), 1);

        return $data = [
            'visitors' => $visitors,
            'avg' => $average,
            'totalVisitors' => $totalVisitors,
            'dates' => $dates,
            'days' => $days + 1
        ];
    }
}
