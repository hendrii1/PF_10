<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Charts\EmployeesChart;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @param EmployeesChart $chart
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(EmployeesChart $chart)
    {
        $pageTitle = 'Home';
        $chartData = $chart->build();
        return view('home', [
            'pageTitle' => $pageTitle,
            'chart' => $chartData
        ]);
    }
}
