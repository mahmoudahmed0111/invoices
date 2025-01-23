<?php

namespace App\Http\Controllers;

use App\Models\invoices;
use Illuminate\Http\Request;

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
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sum1 = invoices::sum('Total') ;
        $count1 = invoices::count() ;
        $sum2 = invoices::where('Value_Status',2)->sum('Total') ;
        $count2 = invoices::where('Value_Status',2)->count() ;
        $sum3 = invoices::where('Value_Status',1)->sum('Total') ;
        $count3 = invoices::where('Value_Status',1)->count() ;
        $sum4 = invoices::where('Value_Status',3)->sum('Total') ;
        $count4 = invoices::where('Value_Status',3)->count() ;
        $count12 = $count2 / $count1 *100; // nspainvoices1
        $count13 = $count3 / $count1 *100; // nspainvoices2
        $count14 = $count4 / $count1 *100; // nspainvoices3


        $chartjs = app()->chartjs
            ->name('barChartTest')
            ->type('bar')
            ->size(['width' => 350, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    "label" => "الفواتير الغير المدفوعة",
                    'backgroundColor' => ['#ec5858'],
                    'data' => [$count12]
                ],
                [
                    "label" => "الفواتير المدفوعة",
                    'backgroundColor' => ['#81b214'],
                    'data' => [$count13]
                ],
                [
                    "label" => "الفواتير المدفوعة جزئيا",
                    'backgroundColor' => ['#ff9642'],
                    'data' => [$count14]
                ],


            ])
            ->options([]);


        $chartjs_2 = app()->chartjs
            ->name('pieChartTest')
            ->type('pie')
            ->size(['width' => 340, 'height' => 200])
            ->labels(['الفواتير الغير المدفوعة', 'الفواتير المدفوعة','الفواتير المدفوعة جزئيا'])
            ->datasets([
                [
                    'backgroundColor' => ['#ec5858', '#81b214','#ff9642'],
                    'data' => [$count12, $count13,$count14]
                ]
            ])
            ->options([]);

        return view('home',compact('sum1', 'count1', 'sum2', 'count2', 'sum3', 'count3', 'sum4', 'count4', 'chartjs', 'chartjs_2'));
    }
}
