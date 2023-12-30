<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dataset;
use App\Models\Datauji;
use App\Charts\DataUjiBar;
use App\Charts\DataUjiNB;
use App\Charts\DataUjiC45;

class DashboardController extends Controller
{
    public function index(DataUjiBar $dataUjiBar, DataUjiNB $dataUjiNB, DataUjiC45 $dataUjiC45)
    {
        return view(
            'dashboard.index',
            [
                'title' => 'Dashboard',
                'total_dataset' => Dataset::count(),
                'total_data_uji' => Datauji::count(),
                'chartbar' => $dataUjiBar->build(),
                'chart_nb_pie' => $dataUjiNB->build(),
                'chart_c45_pie' => $dataUjiC45->build(),
                'datasets' => Dataset::latest()->get(),
                'dataujis' => Datauji::latest()->get(),
            ]
        );
    }
}
