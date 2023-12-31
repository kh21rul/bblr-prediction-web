<?php

namespace App\Http\Controllers;

use App\Charts\DataUjiBar;
use App\Charts\DataUjiC45;
use App\Charts\DataUjiNB;
use App\Charts\DataUjiPie;
use App\Models\Dataset;
use App\Models\Datauji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardDataujiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DataUjiBar $dataUjiBar, DataUjiNB $dataUjiNB, DataUjiC45 $dataUjiC45)
    {
        return view('dashboard.dataujis.index', [
            'title' => 'Data Uji',
            'dataujis' => Datauji::latest()->get(),
            'chartbar' => $dataUjiBar->build(),
            'chart_nb_pie' => $dataUjiNB->build(),
            'chart_c45_pie' => $dataUjiC45->build(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.dataujis.create', [
            'title' => 'Tambah Data Uji',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'umur' => 'required|numeric',
            'lila' => 'required|numeric',
            'tinggi' => 'required|numeric',
        ]);

        // -- Start Naive Bayes --
        // probabilitas C1
        // C1 Ya
        $mean_umur_ya = Dataset::where('bblr', true)->avg('umur');
        $simpangan_baku_umur_ya = sqrt(Dataset::where('bblr', true)->avg(DB::raw('POWER(umur - ' . $mean_umur_ya . ', 2)')));
        $coefficient_c1_ya = 1 / ($simpangan_baku_umur_ya * sqrt(2 * M_PI));
        $exponent_c1_ya = - (($request->umur - $mean_umur_ya) ** 2) / (2 * ($simpangan_baku_umur_ya ** 2));
        $probabilitas_umur_ya  = $coefficient_c1_ya * exp($exponent_c1_ya);
        // C1 Tidak
        $mean_umur_tidak = Dataset::where('bblr', false)->avg('umur');
        $simpangan_baku_umur_tidak = sqrt(Dataset::where('bblr', false)->avg(DB::raw('POWER(umur - ' . $mean_umur_tidak . ', 2)')));
        $coefficient_c1_tidak = 1 / ($simpangan_baku_umur_tidak * sqrt(2 * M_PI));
        $exponent_c1_tidak = - (($request->umur - $mean_umur_tidak) ** 2) / (2 * ($simpangan_baku_umur_tidak ** 2));
        $probabilitas_umur_tidak  = $coefficient_c1_tidak * exp($exponent_c1_tidak);

        // probabilitas C2
        // C2 Ya
        $mean_lila_ya = Dataset::where('bblr', true)->avg('lila');
        $simpangan_baku_lila_ya = sqrt(Dataset::where('bblr', true)->avg(DB::raw('POWER(lila - ' . $mean_lila_ya . ', 2)')));
        $coefficient_c2_ya = 1 / ($simpangan_baku_lila_ya * sqrt(2 * M_PI));
        $exponent_c2_ya = - (($request->lila - $mean_lila_ya) ** 2) / (2 * ($simpangan_baku_lila_ya ** 2));
        $probabilitas_lila_ya  = $coefficient_c2_ya * exp($exponent_c2_ya);
        // C2 Tidak
        $mean_lila_tidak = Dataset::where('bblr', false)->avg('lila');
        $simpangan_baku_lila_tidak = sqrt(Dataset::where('bblr', false)->avg(DB::raw('POWER(lila - ' . $mean_lila_tidak . ', 2)')));
        $coefficient_c2_tidak = 1 / ($simpangan_baku_lila_tidak * sqrt(2 * M_PI));
        $exponent_c2_tidak = - (($request->lila - $mean_lila_tidak) ** 2) / (2 * ($simpangan_baku_lila_tidak ** 2));
        $probabilitas_lila_tidak  = $coefficient_c2_tidak * exp($exponent_c2_tidak);

        // probabilitas C3
        // C3 Ya
        $mean_tinggi_ya = Dataset::where('bblr', true)->avg('tinggi');
        $simpangan_baku_tinggi_ya = sqrt(Dataset::where('bblr', true)->avg(DB::raw('POWER(tinggi - ' . $mean_tinggi_ya . ', 2)')));
        $coefficient_c3_ya = 1 / ($simpangan_baku_tinggi_ya * sqrt(2 * M_PI));
        $exponent_c3_ya = - (($request->tinggi - $mean_tinggi_ya) ** 2) / (2 * ($simpangan_baku_tinggi_ya ** 2));
        $probabilitas_tinggi_ya  = $coefficient_c3_ya * exp($exponent_c3_ya);
        // C3 Tidak
        $mean_tinggi_tidak = Dataset::where('bblr', false)->avg('tinggi');
        $simpangan_baku_tinggi_tidak = sqrt(Dataset::where('bblr', false)->avg(DB::raw('POWER(tinggi - ' . $mean_tinggi_tidak . ', 2)')));
        $coefficient_c3_tidak = 1 / ($simpangan_baku_tinggi_tidak * sqrt(2 * M_PI));
        $exponent_c3_tidak = - (($request->tinggi - $mean_tinggi_tidak) ** 2) / (2 * ($simpangan_baku_tinggi_tidak ** 2));
        $probabilitas_tinggi_tidak  = $coefficient_c3_tidak * exp($exponent_c3_tidak);

        // probabilitas C4
        $probabilitas_bblr_ya = Dataset::where('bblr', true)->count() / Dataset::count();
        $probabilitas_bblr_tidak = Dataset::where('bblr', false)->count() / Dataset::count();

        $likelihood_ya = $probabilitas_umur_ya * $probabilitas_lila_ya * $probabilitas_tinggi_ya * $probabilitas_bblr_ya;
        $likelihood_tidak = $probabilitas_umur_tidak * $probabilitas_lila_tidak * $probabilitas_tinggi_tidak * $probabilitas_bblr_tidak;

        // normalisasi
        $pbb_ya_nb = $likelihood_ya / ($likelihood_ya + $likelihood_tidak);
        $pbb_tidak_nb = $likelihood_tidak / ($likelihood_ya + $likelihood_tidak);

        // klasifikasi
        $validatedData['bblr_nb'] = $pbb_ya_nb > $pbb_tidak_nb ? true : false;
        // End Naive Bayes

        // -- Start C4.5 --
        // cari mean dan median untuk nilai numerik
        $mean_umur = Dataset::avg('umur');
        $umur_values = Dataset::pluck('umur')->toArray();
        sort($umur_values);
        $count = count($umur_values);
        if ($count % 2 == 0) {
            $median_umur = ($umur_values[($count / 2) - 1] + $umur_values[$count / 2]) / 2;
        } else {
            $median_umur = $umur_values[floor($count / 2)];
        }

        $mean_lila = Dataset::avg('lila');
        $lila_values = Dataset::pluck('lila')->toArray();
        sort($lila_values);
        $count = count($lila_values);
        if ($count % 2 == 0) {
            $median_lila = ($lila_values[($count / 2) - 1] + $lila_values[$count / 2]) / 2;
        } else {
            $median_lila = $lila_values[floor($count / 2)];
        }

        $mean_tinggi = Dataset::avg('tinggi');
        $tinggi_values = Dataset::pluck('tinggi')->toArray();
        sort($tinggi_values);
        $count = count($tinggi_values);
        if ($count % 2 == 0) {
            $median_tinggi = ($tinggi_values[($count / 2) - 1] + $tinggi_values[$count / 2]) / 2;
        } else {
            $median_tinggi = $tinggi_values[floor($count / 2)];
        }

        // menghitung entropy dan gain ratio
        // total kasus
        $total_kasus = Dataset::count();
        $total_ya_bblr = Dataset::where('bblr', true)->count();
        $total_tidak_bblr = Dataset::where('bblr', false)->count();
        $entropy_total_bblr = - (($total_ya_bblr / $total_kasus) * log($total_ya_bblr / $total_kasus, 2)) - (($total_tidak_bblr / $total_kasus) * log($total_tidak_bblr / $total_kasus, 2));

        // umur
        $umur_dbwah_mean = Dataset::where('umur', '<=', $mean_umur)->count();
        $umur_dbwah_mean_ya = Dataset::where('umur', '<=', $mean_umur)->where('bblr', true)->count();
        $umur_dbwah_mean_tidak = Dataset::where('umur', '<=', $mean_umur)->where('bblr', false)->count();
        $entropy_umur_dbwah_mean = - (($umur_dbwah_mean_ya / $umur_dbwah_mean) * log($umur_dbwah_mean_ya / $umur_dbwah_mean, 2)) - (($umur_dbwah_mean_tidak / $umur_dbwah_mean) * log($umur_dbwah_mean_tidak / $umur_dbwah_mean, 2));
        $umur_datas_mean = Dataset::where('umur', '>', $mean_umur)->count();
        $umur_datas_mean_ya = Dataset::where('umur', '>', $mean_umur)->where('bblr', true)->count();
        $umur_datas_mean_tidak = Dataset::where('umur', '>', $mean_umur)->where('bblr', false)->count();
        $entropy_umur_datas_mean = - (($umur_datas_mean_ya / $umur_datas_mean) * log($umur_datas_mean_ya / $umur_datas_mean, 2)) - (($umur_datas_mean_tidak / $umur_datas_mean) * log($umur_datas_mean_tidak / $umur_datas_mean, 2));
        $gain_umur_mean = $entropy_total_bblr - ((($umur_dbwah_mean / $total_kasus) * $entropy_umur_dbwah_mean) + (($umur_datas_mean / $total_kasus) * $entropy_umur_datas_mean));

        $umur_dbwah_median = Dataset::where('umur', '<=', $median_umur)->count();
        $umur_dbwah_median_ya = Dataset::where('umur', '<=', $median_umur)->where('bblr', true)->count();
        $umur_dbwah_median_tidak = Dataset::where('umur', '<=', $median_umur)->where('bblr', false)->count();
        $entropy_umur_dbwah_median = - (($umur_dbwah_median_ya / $umur_dbwah_median) * log($umur_dbwah_median_ya / $umur_dbwah_median, 2)) - (($umur_dbwah_median_tidak / $umur_dbwah_median) * log($umur_dbwah_median_tidak / $umur_dbwah_median, 2));
        $umur_datas_median = Dataset::where('umur', '>', $median_umur)->count();
        $umur_datas_median_ya = Dataset::where('umur', '>', $median_umur)->where('bblr', true)->count();
        $umur_datas_median_tidak = Dataset::where('umur', '>', $median_umur)->where('bblr', false)->count();
        $entropy_umur_datas_median = - (($umur_datas_median_ya / $umur_datas_median) * log($umur_datas_median_ya / $umur_datas_median, 2)) - (($umur_datas_median_tidak / $umur_datas_median) * log($umur_datas_median_tidak / $umur_datas_median, 2));
        $gain_umur_median = $entropy_total_bblr - ((($umur_dbwah_median / $total_kasus) * $entropy_umur_dbwah_median) + (($umur_datas_median / $total_kasus) * $entropy_umur_datas_median));

        // lila
        $lila_dbwah_mean = Dataset::where('lila', '<=', $mean_lila)->count();
        $lila_dbwah_mean_ya = Dataset::where('lila', '<=', $mean_lila)->where('bblr', true)->count();
        $lila_dbwah_mean_tidak = Dataset::where('lila', '<=', $mean_lila)->where('bblr', false)->count();
        $entropy_lila_dbwah_mean = - (($lila_dbwah_mean_ya / $lila_dbwah_mean) * log($lila_dbwah_mean_ya / $lila_dbwah_mean, 2)) - (($lila_dbwah_mean_tidak / $lila_dbwah_mean) * log($lila_dbwah_mean_tidak / $lila_dbwah_mean, 2));
        $lila_datas_mean = Dataset::where('lila', '>', $mean_lila)->count();
        $lila_datas_mean_ya = Dataset::where('lila', '>', $mean_lila)->where('bblr', true)->count();
        $lila_datas_mean_tidak = Dataset::where('lila', '>', $mean_lila)->where('bblr', false)->count();
        $entropy_lila_datas_mean = - (($lila_datas_mean_ya / $lila_datas_mean) * log($lila_datas_mean_ya / $lila_datas_mean, 2)) - (($lila_datas_mean_tidak / $lila_datas_mean) * log($lila_datas_mean_tidak / $lila_datas_mean, 2));
        $gain_lila_mean = $entropy_total_bblr - ((($lila_dbwah_mean / $total_kasus) * $entropy_lila_dbwah_mean) + (($lila_datas_mean / $total_kasus) * $entropy_lila_datas_mean));

        $lila_dbwah_median = Dataset::where('lila', '<=', $median_lila)->count();
        $lila_dbwah_median_ya = Dataset::where('lila', '<=', $median_lila)->where('bblr', true)->count();
        $lila_dbwah_median_tidak = Dataset::where('lila', '<=', $median_lila)->where('bblr', false)->count();
        $entropy_lila_dbwah_median = - (($lila_dbwah_median_ya / $lila_dbwah_median) * log($lila_dbwah_median_ya / $lila_dbwah_median, 2)) - (($lila_dbwah_median_tidak / $lila_dbwah_median) * log($lila_dbwah_median_tidak / $lila_dbwah_median, 2));
        $lila_datas_median = Dataset::where('lila', '>', $median_lila)->count();
        $lila_datas_median_ya = Dataset::where('lila', '>', $median_lila)->where('bblr', true)->count();
        $lila_datas_median_tidak = Dataset::where('lila', '>', $median_lila)->where('bblr', false)->count();
        $entropy_lila_datas_median = - (($lila_datas_median_ya / $lila_datas_median) * log($lila_datas_median_ya / $lila_datas_median, 2)) - (($lila_datas_median_tidak / $lila_datas_median) * log($lila_datas_median_tidak / $lila_datas_median, 2));
        $gain_lila_median = $entropy_total_bblr - ((($lila_dbwah_median / $total_kasus) * $entropy_lila_dbwah_median) + (($lila_datas_median / $total_kasus) * $entropy_lila_datas_median));

        // tinggi
        $tinggi_dbwah_mean = Dataset::where('tinggi', '<=', $mean_tinggi)->count();
        $tinggi_dbwah_mean_ya = Dataset::where('tinggi', '<=', $mean_tinggi)->where('bblr', true)->count();
        $tinggi_dbwah_mean_tidak = Dataset::where('tinggi', '<=', $mean_tinggi)->where('bblr', false)->count();
        $entropy_tinggi_dbwah_mean = - (($tinggi_dbwah_mean_ya / $tinggi_dbwah_mean) * log($tinggi_dbwah_mean_ya / $tinggi_dbwah_mean, 2)) - (($tinggi_dbwah_mean_tidak / $tinggi_dbwah_mean) * log($tinggi_dbwah_mean_tidak / $tinggi_dbwah_mean, 2));
        $tinggi_datas_mean = Dataset::where('tinggi', '>', $mean_tinggi)->count();
        $tinggi_datas_mean_ya = Dataset::where('tinggi', '>', $mean_tinggi)->where('bblr', true)->count();
        $tinggi_datas_mean_tidak = Dataset::where('tinggi', '>', $mean_tinggi)->where('bblr', false)->count();
        $entropy_tinggi_datas_mean = - (($tinggi_datas_mean_ya / $tinggi_datas_mean) * log($tinggi_datas_mean_ya / $tinggi_datas_mean, 2)) - (($tinggi_datas_mean_tidak / $tinggi_datas_mean) * log($tinggi_datas_mean_tidak / $tinggi_datas_mean, 2));
        $gain_tinggi_mean = $entropy_total_bblr - ((($tinggi_dbwah_mean / $total_kasus) * $entropy_tinggi_dbwah_mean) + (($tinggi_datas_mean / $total_kasus) * $entropy_tinggi_datas_mean));

        $tinggi_dbwah_median = Dataset::where('tinggi', '<=', $median_tinggi)->count();
        $tinggi_dbwah_median_ya = Dataset::where('tinggi', '<=', $median_tinggi)->where('bblr', true)->count();
        $tinggi_dbwah_median_tidak = Dataset::where('tinggi', '<=', $median_tinggi)->where('bblr', false)->count();
        $entropy_tinggi_dbwah_median = - (($tinggi_dbwah_median_ya / $tinggi_dbwah_median) * log($tinggi_dbwah_median_ya / $tinggi_dbwah_median, 2)) - (($tinggi_dbwah_median_tidak / $tinggi_dbwah_median) * log($tinggi_dbwah_median_tidak / $tinggi_dbwah_median, 2));
        $tinggi_datas_median = Dataset::where('tinggi', '>', $median_tinggi)->count();
        $tinggi_datas_median_ya = Dataset::where('tinggi', '>', $median_tinggi)->where('bblr', true)->count();
        $tinggi_datas_median_tidak = Dataset::where('tinggi', '>', $median_tinggi)->where('bblr', false)->count();
        $entropy_tinggi_datas_median = - (($tinggi_datas_median_ya / $tinggi_datas_median) * log($tinggi_datas_median_ya / $tinggi_datas_median, 2)) - (($tinggi_datas_median_tidak / $tinggi_datas_median) * log($tinggi_datas_median_tidak / $tinggi_datas_median, 2));
        $gain_tinggi_median = $entropy_total_bblr - ((($tinggi_dbwah_median / $total_kasus) * $entropy_tinggi_dbwah_median) + (($tinggi_datas_median / $total_kasus) * $entropy_tinggi_datas_median));

        // membuat pohon keputusan
        $gain_tertinggi = max($gain_umur_mean, $gain_umur_median, $gain_lila_mean, $gain_lila_median, $gain_tinggi_mean, $gain_tinggi_median);

        if ($gain_tertinggi == $gain_umur_mean) {
            return "gain umur main";
        } elseif ($gain_tertinggi == $gain_umur_median) {
            return "gain umur median";
        } elseif ($gain_tertinggi == $gain_lila_mean) {
            return "gain lila mean";
        } elseif ($gain_tertinggi == $gain_lila_median) {
            if ($lila_dbwah_median_ya == 0) {
            }
        } elseif ($gain_tertinggi == $gain_tinggi_mean) {
            return "gain tinggi mean";
        } elseif ($gain_tertinggi == $gain_tinggi_median) {
            return "gain tinggi median";
        } else {
            return "tidak ada";
        }

        ddd($gain_tertinggi);

        $validatedData['bblr_c45'] = false;

        Datauji::create($validatedData);

        return redirect()->route('dashboard.dataujis.index')->with('success', 'Data uji berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Datauji $datauji)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Datauji $datauji)
    {
        return view('dashboard.dataujis.edit', [
            'title' => 'Edit Data Uji',
            'datauji' => $datauji,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Datauji $datauji)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'umur' => 'required|numeric',
            'lila' => 'required|numeric',
            'tinggi' => 'required|numeric',
        ]);

        // Start Naive Bayes
        // probabilitas C1
        // C1 Ya
        $mean_umur_ya = Dataset::where('bblr', true)->avg('umur');
        $simpangan_baku_umur_ya = sqrt(Dataset::where('bblr', true)->avg(DB::raw('POWER(umur - ' . $mean_umur_ya . ', 2)')));
        $coefficient_c1_ya = 1 / ($simpangan_baku_umur_ya * sqrt(2 * M_PI));
        $exponent_c1_ya = - (($request->umur - $mean_umur_ya) ** 2) / (2 * ($simpangan_baku_umur_ya ** 2));
        $probabilitas_umur_ya  = $coefficient_c1_ya * exp($exponent_c1_ya);
        // C1 Tidak
        $mean_umur_tidak = Dataset::where('bblr', false)->avg('umur');
        $simpangan_baku_umur_tidak = sqrt(Dataset::where('bblr', false)->avg(DB::raw('POWER(umur - ' . $mean_umur_tidak . ', 2)')));
        $coefficient_c1_tidak = 1 / ($simpangan_baku_umur_tidak * sqrt(2 * M_PI));
        $exponent_c1_tidak = - (($request->umur - $mean_umur_tidak) ** 2) / (2 * ($simpangan_baku_umur_tidak ** 2));
        $probabilitas_umur_tidak  = $coefficient_c1_tidak * exp($exponent_c1_tidak);

        // probabilitas C2
        // C2 Ya
        $mean_lila_ya = Dataset::where('bblr', true)->avg('lila');
        $simpangan_baku_lila_ya = sqrt(Dataset::where('bblr', true)->avg(DB::raw('POWER(lila - ' . $mean_lila_ya . ', 2)')));
        $coefficient_c2_ya = 1 / ($simpangan_baku_lila_ya * sqrt(2 * M_PI));
        $exponent_c2_ya = - (($request->lila - $mean_lila_ya) ** 2) / (2 * ($simpangan_baku_lila_ya ** 2));
        $probabilitas_lila_ya  = $coefficient_c2_ya * exp($exponent_c2_ya);
        // C2 Tidak
        $mean_lila_tidak = Dataset::where('bblr', false)->avg('lila');
        $simpangan_baku_lila_tidak = sqrt(Dataset::where('bblr', false)->avg(DB::raw('POWER(lila - ' . $mean_lila_tidak . ', 2)')));
        $coefficient_c2_tidak = 1 / ($simpangan_baku_lila_tidak * sqrt(2 * M_PI));
        $exponent_c2_tidak = - (($request->lila - $mean_lila_tidak) ** 2) / (2 * ($simpangan_baku_lila_tidak ** 2));
        $probabilitas_lila_tidak  = $coefficient_c2_tidak * exp($exponent_c2_tidak);

        // probabilitas C3
        // C3 Ya
        $mean_tinggi_ya = Dataset::where('bblr', true)->avg('tinggi');
        $simpangan_baku_tinggi_ya = sqrt(Dataset::where('bblr', true)->avg(DB::raw('POWER(tinggi - ' . $mean_tinggi_ya . ', 2)')));
        $coefficient_c3_ya = 1 / ($simpangan_baku_tinggi_ya * sqrt(2 * M_PI));
        $exponent_c3_ya = - (($request->tinggi - $mean_tinggi_ya) ** 2) / (2 * ($simpangan_baku_tinggi_ya ** 2));
        $probabilitas_tinggi_ya  = $coefficient_c3_ya * exp($exponent_c3_ya);
        // C3 Tidak
        $mean_tinggi_tidak = Dataset::where('bblr', false)->avg('tinggi');
        $simpangan_baku_tinggi_tidak = sqrt(Dataset::where('bblr', false)->avg(DB::raw('POWER(tinggi - ' . $mean_tinggi_tidak . ', 2)')));
        $coefficient_c3_tidak = 1 / ($simpangan_baku_tinggi_tidak * sqrt(2 * M_PI));
        $exponent_c3_tidak = - (($request->tinggi - $mean_tinggi_tidak) ** 2) / (2 * ($simpangan_baku_tinggi_tidak ** 2));
        $probabilitas_tinggi_tidak  = $coefficient_c3_tidak * exp($exponent_c3_tidak);

        // probabilitas C4
        $probabilitas_bblr_ya = Dataset::where('bblr', true)->count() / Dataset::count();
        $probabilitas_bblr_tidak = Dataset::where('bblr', false)->count() / Dataset::count();

        $likelihood_ya = $probabilitas_umur_ya * $probabilitas_lila_ya * $probabilitas_tinggi_ya * $probabilitas_bblr_ya;
        $likelihood_tidak = $probabilitas_umur_tidak * $probabilitas_lila_tidak * $probabilitas_tinggi_tidak * $probabilitas_bblr_tidak;

        // normalisasi
        $pbb_ya_nb = $likelihood_ya / ($likelihood_ya + $likelihood_tidak);
        $pbb_tidak_nb = $likelihood_tidak / ($likelihood_ya + $likelihood_tidak);

        // klasifikasi
        $validatedData['bblr_nb'] = $pbb_ya_nb > $pbb_tidak_nb ? true : false;
        // End Naive Bayes

        $validatedData['bblr_c45'] = false;

        $datauji->update($validatedData);

        return redirect()->route('dashboard.dataujis.index')->with('success', 'Data uji berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Datauji $datauji)
    {
        Datauji::destroy($datauji->id);

        return redirect()->route('dashboard.dataujis.index')->with('success', 'Data uji berhasil dihapus');
    }

    public function simpannb(Datauji $datauji)
    {
        // cek apakah data sudah ada di dataset
        $data = Dataset::where('nama', $datauji->nama)->where('umur', $datauji->umur)->where('lila', $datauji->lila)->where('tinggi', $datauji->tinggi)->count();
        if ($data > 0) {
            return redirect()->back()->with('error', 'Data sudah ada di dataset');
        }
        $validatedData['nama'] = $datauji->nama;
        $validatedData['umur'] = $datauji->umur;
        $validatedData['lila'] = $datauji->lila;
        $validatedData['tinggi'] = $datauji->tinggi;
        $validatedData['bblr'] = $datauji->bblr_nb;

        Dataset::create($validatedData);

        return redirect()->route('dashboard.datasets.index')->with('success', 'Dataset baru berhasil ditambah');
    }

    public function simpanc45(Datauji $datauji)
    {
        // cek apakah data sudah ada di dataset
        $data = Dataset::where('nama', $datauji->nama)->where('umur', $datauji->umur)->where('lila', $datauji->lila)->where('tinggi', $datauji->tinggi)->count();
        if ($data > 0) {
            return redirect()->back()->with('error', 'Data sudah ada di dataset');
        }
        $validatedData['nama'] = $datauji->nama;
        $validatedData['umur'] = $datauji->umur;
        $validatedData['lila'] = $datauji->lila;
        $validatedData['tinggi'] = $datauji->tinggi;
        $validatedData['bblr'] = $datauji->bblr_c45;

        Dataset::create($validatedData);

        return redirect()->route('dashboard.datasets.index')->with('success', 'Dataset baru berhasil ditambah');
    }
}
