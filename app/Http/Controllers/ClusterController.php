<?php

namespace App\Http\Controllers;

use App\Models\Cluster;
use App\Http\Requests\StoreClustersRequest;
use App\Http\Requests\UpdateClustersRequest;
use App\Models\Unit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class ClusterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!auth()->user()->hasRole('Super Admin|Admin|Staff|Student')) {
            return redirect('/')->with('error', 'Unauthorised to access this page.');
        }
        $clusters = Cluster::paginate(6);
        return view('clusters.index', compact(['clusters', ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (!auth()->user()->hasRole('Super Admin|Admin')) {
            return redirect('/')->with('error', 'Unauthorised to create clusters');
        }
        $units = Unit::all();
        return view('clusters.create', compact(['units']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => ['required', 'min:5', 'max:9', 'string', 'regex:/^[A-Z0-9-]+$/'],
            'title' => ['required', 'min:5', 'max:255', 'string',],
            'qualification' => ['nullable', 'string', 'regex:/^ICT\d{5}$/'],
            'qualification_code' => ['nullable', 'string', 'regex:/^AC\d{2}$/'],
            'unit_1' =>['nullable', 'string'],
            'unit_2' => ['nullable', 'string'],
            'unit_3' => ['nullable', 'string'],
            'unit_4' => ['nullable', 'string'],
            'unit_5' => ['nullable', 'string'],
            'unit_6' => ['nullable', 'string'],
            'unit_7' => ['nullable', 'string'],
            'unit_8' => ['nullable', 'string'],
        ]);



        Cluster::create($validated);

        return redirect()->route('clusters.index')
            ->with('success', 'Cluster created successfully');
    }


    /**
     * Display the specified resource.
     */

    public function show(string $id)
    {
        if (!auth()->user()->hasRole('Super Admin|Admin|Staff|Student')) {
            return redirect('/')->with('error', 'Unauthorised to view clusters details.');
        }
        $cluster = Cluster::find($id);

        if ($cluster) {
            // Collect the unit IDs from the cluster (unit_1, unit_2, etc.)
            $unitIds = [];
            foreach (range(1, 8) as $unit) {
                $unitId = $cluster->{'unit_' . $unit};
                if ($unitId) {
                    $unitIds[] = $unitId; // Add the unit ID to the array if it exists
                }
            }

            $units = Unit::whereIn('national_code', $unitIds)->get();

//            dd($cluster);

            return view('clusters.show', compact('cluster', 'units'))
                ->with('success', 'Cluster found');
        }

        return redirect(route('clusters.index'))
            ->with('warning', 'Cluster not found');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (!auth()->user()->hasRole('Super Admin|Admin')) {
            return redirect('/')->with('error', 'Unauthorised to edit clusters.');
        }

        $cluster = Cluster::findOrFail($id);
        $units = Unit::all();

        return view('clusters.edit', compact('cluster', 'units'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'code' => ['required', 'min:5', 'max:9', 'string', 'regex:/^[A-Z0-9-]+$/'],
            'title' => ['required', 'min:5', 'max:255', 'string',],
            'qualification' => ['nullable', 'string', 'regex:/^ICT\d{5}$/'],
            'qualification_code' => ['nullable', 'string', 'regex:/^AC\d{2}$/'],
            'unit_1' =>['nullable', 'string'],
            'unit_2' => ['nullable', 'string'],
            'unit_3' => ['nullable', 'string'],
            'unit_4' => ['nullable', 'string'],
            'unit_5' => ['nullable', 'string'],
            'unit_6' => ['nullable', 'string'],
            'unit_7' => ['nullable', 'string'],
            'unit_8' => ['nullable', 'string'],
        ]);

        Cluster::whereId($id)->update($validated);

        return redirect()->route('clusters.index')
            ->with('success', 'Cluster updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cluster $cluster)
    {
        if (!auth()->user()->hasRole('Super Admin|Admin')) {
            return redirect('/')->with('error', 'Unauthorised to delete clusters.');
        }
        $cluster->delete();
        return redirect()->route('clusters.index')
            ->with('success', 'Cluster deleted successfully');
    }

    public function addUnitToController($cluster_id, $unit_id)
    {
        $cluster = Cluster::findOrFail($cluster_id);
        $unit = Unit::findOrFail($unit_id);

        $cluster->units()->attach($unit);
    }

}
