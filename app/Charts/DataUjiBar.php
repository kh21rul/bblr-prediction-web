<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\DataUji;

class DataUjiBar
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\BarChart
    {
        $data_ujis = DataUji::all();
        $data_bblr = [
            $data_ujis->where('bblr_nb', true)->count(),
            $data_ujis->where('bblr_c45', true)->count(),
        ];
        $data_non_bblr = [
            $data_ujis->where('bblr_nb', false)->count(),
            $data_ujis->where('bblr_c45', false)->count(),
        ];
        $label = [
            'Naive Bayes',
            'C4.5',
        ];
        return $this->chart->barChart()
            ->setTitle('Data Ibu Hamil Teridentifikasi BBLR')
            ->setSubtitle('Berdasarkan Data Uji')
            ->addData('Terindentifikasi', $data_bblr)
            ->addData('Tidak Teridentifikasi', $data_non_bblr)
            ->setXAxis($label);
    }
}
