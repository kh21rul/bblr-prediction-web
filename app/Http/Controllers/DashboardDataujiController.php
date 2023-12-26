<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use App\Models\Datauji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardDataujiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.dataujis.index', [
            'title' => 'Data Uji',
            'dataujis' => Datauji::latest()->get(),
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
        $validatedData['pbb_ya_nb'] = $likelihood_ya / ($likelihood_ya + $likelihood_tidak);
        $validatedData['pbb_tidak_nb'] = $likelihood_tidak / ($likelihood_ya + $likelihood_tidak);
        // End Naive Bayes

        $validatedData['bblr_nb'] = $validatedData['pbb_ya_nb'] > $validatedData['pbb_tidak_nb'] ? true : false;
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
        $validatedData['pbb_ya_nb'] = $likelihood_ya / ($likelihood_ya + $likelihood_tidak);
        $validatedData['pbb_tidak_nb'] = $likelihood_tidak / ($likelihood_ya + $likelihood_tidak);
        // End Naive Bayes

        $validatedData['bblr_nb'] = $validatedData['pbb_ya_nb'] > $validatedData['pbb_tidak_nb'] ? true : false;
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
}
