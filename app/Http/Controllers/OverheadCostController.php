<?php

namespace App\Http\Controllers;

use App\Models\OverheadCost;
use Illuminate\Http\Request;

class OverheadCostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $overheadCosts = OverheadCost::all();
        return view('overhead_costs.index', compact('overheadCosts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('overhead_costs.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
        ]);

        OverheadCost::create($validated);

        return redirect()->route('overhead_costs.index')->with('success', 'Overhead cost created successfully.');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OverheadCost $overheadCost)
    {
        return view('overhead_costs.edit', compact('overheadCost'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, OverheadCost $overheadCost)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:fixed,percentage',
            'value' => 'required|numeric|min:0',
        ]);

        $overheadCost->update($validated);

        return redirect()->route('overhead_costs.index')->with('success', 'Overhead cost updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(OverheadCost $overheadCost)
    {
        $overheadCost->delete();
        return redirect()->route('overhead_costs.index')->with('success', 'Overhead cost deleted successfully.');
    }
}