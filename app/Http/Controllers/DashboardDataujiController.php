<?php

namespace App\Http\Controllers;

use App\Models\Datauji;
use Illuminate\Http\Request;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Datauji $datauji)
    {
        //
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
