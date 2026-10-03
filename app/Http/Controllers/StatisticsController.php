<?php

namespace App\Http\Controllers;

use DateInterval;
use DatePeriod;
use DateTime;
use Google_Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class StatisticsController extends Controller
{
    public $days = 30;

    function index()
    {
        $days = $this->days;
        $to = new DateTime('today');
        $from = (clone $to)->modify("-$days days");

        $daily = $this->dailyVisitors($from, $to);
        $totalVisitors = array_sum($daily['visitors']);
        $liveUsers = $this->liveUsers();

        return view('statistics', [
            'avg' => round($totalVisitors / $days, 1),
            'liveUsers' => $liveUsers['liveUsers'],
            'liveDetails' => $liveUsers['details'],
            'visitors' => $daily['visitors'],
            'totalVisitors' => $totalVisitors,
            'dates' => $daily['dates'],
            'days' => $days
        ]);
    }

    function liveUsers()
    {
        $liveUsers = 0;
        $details = [];

        $response = $this->request('runRealtimeReport', [
            'dimensions' => [['name' => 'country'], ['name' => 'deviceCategory']],
            'metrics' => [['name' => 'activeUsers']],
        ]);

        foreach ($response['rows'] ?? [] as $row) {
            $count = (int)$row['metricValues'][0]['value'];
            $details[] = [$row['dimensionValues'][0]['value'], $row['dimensionValues'][1]['value'], $count];
            $liveUsers += $count;
        }

        return ['liveUsers' => $liveUsers, 'details' => $details];
    }

    function getCountries($days)
    {
        $to = new DateTime('today');
        $from = (clone $to)->modify("-$days days");

        $response = $this->request('runReport', [
            'dateRanges' => [['startDate' => $from->format('Y-m-d'), 'endDate' => $to->format('Y-m-d')]],
            'dimensions' => [['name' => 'country']],
            'metrics' => [['name' => 'sessions']],
            'orderBys' => [['metric' => ['metricName' => 'sessions'], 'desc' => true]],
        ]);

        $countriesTotal = [];
        $countriesTotalNo = [];
        foreach ($response['rows'] ?? [] as $k => $row) {
            $countriesTotal[$k] = $row['dimensionValues'][0]['value'];
            $countriesTotalNo[$k] = (int)$row['metricValues'][0]['value'];
        }

        return [
            'countries' => $countriesTotal,
            'visitsPerCountry' => $countriesTotalNo
        ];
    }

    function getData(Request $request)
    {
        $from = DateTime::createFromFormat('d.m.Y', $request->datefrom)->setTime(0, 0);
        $to = DateTime::createFromFormat('d.m.Y', $request->dateto)->setTime(0, 0);

        $daily = $this->dailyVisitors($from, $to);
        $totalVisitors = array_sum($daily['visitors']);
        $days = count($daily['visitors']);

        return [
            'visitors' => $daily['visitors'],
            'avg' => round($totalVisitors / $days, 1),
            'totalVisitors' => $totalVisitors,
            'dates' => $daily['dates'],
            'days' => $days
        ];
    }

    private function dailyVisitors(DateTime $from, DateTime $to)
    {
        $key = 'ga4.daily.' . $from->format('Ymd') . '.' . $to->format('Ymd');

        $rows = Cache::remember($key, 60, function () use ($from, $to) {
            $response = $this->request('runReport', [
                'dateRanges' => [['startDate' => $from->format('Y-m-d'), 'endDate' => $to->format('Y-m-d')]],
                'dimensions' => [['name' => 'date']],
                'metrics' => [['name' => 'totalUsers']],
                'orderBys' => [['dimension' => ['dimensionName' => 'date']]],
            ]);

            $rows = [];
            foreach ($response['rows'] ?? [] as $row) {
                $rows[$row['dimensionValues'][0]['value']] = (int)$row['metricValues'][0]['value'];
            }
            return $rows;
        });

        $visitors = [];
        $dates = [];
        $period = new DatePeriod($from, new DateInterval('P1D'), (clone $to)->modify('+1 day'));
        foreach ($period as $day) {
            $visitors[] = $rows[$day->format('Ymd')] ?? 0;
            $dates[] = $day->format('d.m');
        }

        return ['visitors' => $visitors, 'dates' => $dates];
    }

    private function request($method, array $body)
    {
        $client = new Google_Client();
        $client->setAuthConfig(config('analytics.service_account_credentials_json'));
        $client->addScope('https://www.googleapis.com/auth/analytics.readonly');

        $url = 'https://analyticsdata.googleapis.com/v1beta/properties/'
            . env('ANALYTICS_PROPERTY_ID') . ':' . $method;

        $response = $client->authorize()->post($url, ['json' => $body]);

        return json_decode((string)$response->getBody(), true);
    }
}
