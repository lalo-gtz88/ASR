<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelDaily\LaravelCharts\Classes\LaravelChart;

class HomeController extends Controller
{

    public function dashboard(){
        return view('home');
    }

    public function index()
    {

        $chart_options = [

            'chart_title' => 'Tickets por mes',
            'report_type' => 'group_by_date',
            'model' => 'App\Models\VTickets',
            'group_by_field' => 'created_at',
            'group_by_period' => 'month',
            'chart_type' => 'line',
            

        ];



        $chart1 = new LaravelChart($chart_options);

        $chart_options = [

            'chart_title' => 'Tickets por status',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\VTickets',
            'group_by_field' => 'status',
            'group_by_period' => 'month',
            'chart_type' => 'pie',
            'filter_field' => 'status',

        ];

        $chart2 = new LaravelChart($chart_options);

        $chart_options = [

            'chart_title' => 'Tickets asignados',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\VTickets',
            'group_by_field' => 'asignado',
            'group_by_period' => 'month',
            'chart_type' => 'bar',
            'filter_field' => 'status',

        ];

        $chart3 = new LaravelChart($chart_options);


        $chart_options = [

            'chart_title' => 'Tickets por departamento',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\VTickets',
            'group_by_field' => 'departamento',
            'group_by_period' => 'month',
            'chart_type' => 'bar',
            'filter_field' => 'status',

        ];

        $chart4 = new LaravelChart($chart_options);


        $chart_options = [

            'chart_title' => 'Tickets por categoria',
            'report_type' => 'group_by_string',
            'model' => 'App\Models\VTickets',
            'group_by_field' => 'categoria',
            'group_by_period' => 'month',
            'chart_type' => 'pie',
            'filter_field' => 'status',

        ];

        $chart5 = new LaravelChart($chart_options);


        return view('welcome', compact(
            'chart1',
            'chart2',
            'chart3',
            'chart4',
            'chart5'
        ));
    }
}
