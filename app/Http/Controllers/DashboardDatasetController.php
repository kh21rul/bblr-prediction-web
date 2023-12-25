<?php

namespace App\Http\Controllers;

use App\Models\Dataset;
use Dflydev\DotAccessData\Data;
use Illuminate\Http\Request;

class DashboardDatasetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view(
            'dashboard.datasets.index',
            [
                'title' => 'Dataset',
                'datasets' => Dataset::latest()->get(),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view(
            'dashboard.datasets.create',
            [
                'title' => 'Tambah Dataset',
            ]
        );
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

        if ($request->has('bblr')) {
            $validatedData['bblr'] = true;
        } else {
            $validatedData['bblr'] = false;
        }

        Dataset::create($validatedData);

        return redirect()->route('dashboard.datasets.index')->with('success', 'Data Ibu berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Dataset $dataset)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dataset $dataset)
    {
        return view(
            'dashboard.datasets.edit',
            [
                'title' => 'Edit Dataset',
                'dataset' => $dataset,
            ]
        );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dataset $dataset)
    {
        $validatedData = $request->validate([
            'nama' => 'required|max:255',
            'umur' => 'required|numeric',
            'lila' => 'required|numeric',
            'tinggi' => 'required|numeric',
        ]);

        if ($request->has('bblr')) {
            $validatedData['bblr'] = true;
        } else {
            $validatedData['bblr'] = false;
        }

        $dataset->update($validatedData);

        return redirect()->route('dashboard.datasets.index')->with('success', 'Data Ibu berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dataset $dataset)
    {
        Dataset::destroy($dataset->id);

        return redirect()->route('dashboard.datasets.index')->with('success', 'Data Ibu berhasil dihapus');
    }
}
