<?php

namespace App\Http\Controllers;

use App\Models\Unit;
use App\Http\Requests\StoreUnitsRequest;
use App\Http\Requests\UpdateUnitsRequest;
use Illuminate\Http\Request;

class UnitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasRole('Super Admin|Admin|Staff|Student')) {
            return redirect('/')->with('error', 'Unauthorised to access this page.');
        }

        $units = Unit::paginate(6);
        return view('units.index', compact(['units', ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasRole('Super Admin|Admin')) {
            return redirect('/')->with('error', 'Unauthorised to create unit.');
        }

        return view('units.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'national_code' => ['required', 'string', 'size:9'],
            'title' => ['required', 'min:5', 'max:255', 'string',],
            'tga_status' => ['nullable', 'min:5', 'max:255', 'string',],
            'state_code' => ['nullable', 'string', 'size:5'],
            'nominal_hours' => ['nullable', 'min:1', 'max:200', 'numeric',]
        ]);

        Unit::create($validated);

        return redirect()->route('units.index')
            ->with('success', 'Unit created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        if (!auth()->user()->hasRole('Super Admin|Admin')) {
            return redirect('/')->with('error', 'Unauthorised to view unit.');
        }

        $unit = Unit::whereId($id)->get()->first();

        if ($unit) {
            return view('units.show', compact(['unit',]))
                ->with('success', 'Unit found')
                ;
        }

        return redirect(route('units.index'))
            ->with('warning', 'Unit not found');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Unit $unit)
    {
        if (!auth()->user()->hasRole('Super Admin|Admin')) {
            return redirect('/')->with('error', 'Unauthorised to edit unit.');
        }

        return view('units.edit', compact('unit'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'national_code' => ['required', 'string', 'size:9'],
            'title' => ['required', 'min:5', 'max:255', 'string',],
            'tga_status' => ['nullable', 'min:5', 'max:255', 'string',],
            'state_code' => ['nullable', 'string', 'size:5'],
            'nominal_hours' => ['nullable', 'min:1', 'max:200', 'numeric',]
        ]);
        Unit::whereId($id)->update($validated);

        return redirect()->route('units.index')
            ->with('success', 'Unit updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Unit $unit)
    {
        if (!auth()->user()->hasRole('Super Admin|Admin')) {
            return redirect('/')->with('error', 'Unauthorised to delete unit.');
        }

        $unit->delete();
        return redirect()->route('units.index')
            ->with('success', 'Unit deleted successfully');
    }
}
