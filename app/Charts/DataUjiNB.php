<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\DataUji;

class DataUjiNB
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        $data_ujis = DataUji::all();
        $data = [
            $data_ujis->where('bblr_nb', true)->count(),
            $data_ujis->where('bblr_nb', false)->count(),
        ];
        $label = [
            'Teridentifikasi BBLR',
            'Tidak Teridentifikasi BBLR',
        ];
        return $this->chart->pieChart()
            ->setTitle('Data Ibu Hamil Teridentifikasi BBLR')
            ->setSubtitle('Berdasarkan Data Uji')
            ->addData($data)
            ->setLabels($label);
    }
}
