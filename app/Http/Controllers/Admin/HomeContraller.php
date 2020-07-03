<?php

namespace App\Http\Controllers\Admin;

use LaravelDaily\LaravelCharts\Classes\LaravelChart;
use App\Invoice;
use App\User;
use App\Hospital;
use App\MedicalInformation;
class HomeController{

       public function index()
    {
        $settings1 = [
            'chart_title'           => 'Users By Month',
            'chart_type'            => 'bar',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\\User',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'month',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'column_class'          => 'col-md-8',
            'entries_number'        => '5',
        ];

        $chart1 = new LaravelChart($settings1);   

        $settings2 = [
            'chart_title'           => 'Income & Expense',
            'chart_type'            => 'pie',
            'report_type'           => 'group_by_date',
            'model'                 => 'App\\User',
            'group_by_field'        => 'created_at',
            'group_by_period'       => 'month',
            'aggregate_function'    => 'count',
            'filter_field'          => 'created_at',
            'column_class'          => 'col-md-4',
        ];

        $chart2 = new LaravelChart($settings2);      
        
        // recent invoice
        $hospitals = Hospital::all();
        $users = User::whereHas('roles', function ($q) {$q->whereNotIn('roles.title', ['member']);})->get();
        $members = User::whereHas('roles', function ($q) {$q->whereIn('roles.title', ['member']);})->get();
        $invoices=Invoice::orderBy('id','desc')->take(5)->get();

        $medical_informations = MedicalInformation::all();

        return view('home', compact('chart1','invoices','hospitals','users','members','medical_informations'));
    }

}
