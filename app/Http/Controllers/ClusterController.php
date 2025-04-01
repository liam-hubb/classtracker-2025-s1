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
        $clusters = Cluster::paginate(6);
        return view('clusters.index', compact(['clusters', ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
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
            'unit_1' =>['nullable', 'string', 'regex:/^[A-Z]{6}\d{3}$/'],
            'unit_2' => ['nullable', 'string', 'regex:/^[A-Z]{6}\d{3}$/'],
            'unit_3' => ['nullable', 'string', 'regex:/^[A-Z]{6}\d{3}$/'],
            'unit_4' => ['nullable', 'string', 'regex:/^[A-Z]{6}\d{3}$/'],
            'unit_5' => ['nullable', 'string', 'regex:/^[A-Z]{6}\d{3}$/'],
            'unit_6' => ['nullable', 'string', 'regex:/^[A-Z]{6}\d{3}$/'],
            'unit_7' => ['nullable', 'string', 'regex:/^[A-Z]{6}\d{3}$/'],
            'unit_8' => ['nullable', 'string', 'regex:/^[A-Z]{6}\d{3}$/'],
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

            $cluster = Cluster::find($id);

            if ($cluster) {
                return view('clusters.show', compact(['cluster',]))
                    ->with('success', 'Cluster found');
            }

            return redirect(route('clusters.index'))
                ->with('warning', 'Cluster not found');
        }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cluster $cluster)
    {
        $units = Unit::all();
        return view('clusters.edit', compact(['cluster', 'units']));
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
            'unit_1' =>['nullable', 'string', 'regex:/^[A-Z]{6}\d{3}$/'],
            'unit_2' => ['nullable', 'string', 'regex:/^[A-Z]{6}\d{3}$/'],
            'unit_3' => ['nullable', 'string', 'regex:/^[A-Z]{6}\d{3}$/'],
            'unit_4' => ['nullable', 'string', 'regex:/^[A-Z]{6}\d{3}$/'],
            'unit_5' => ['nullable', 'string', 'regex:/^[A-Z]{6}\d{3}$/'],
            'unit_6' => ['nullable', 'string', 'regex:/^[A-Z]{6}\d{3}$/'],
            'unit_7' => ['nullable', 'string', 'regex:/^[A-Z]{6}\d{3}$/'],
            'unit_8' => ['nullable', 'string', 'regex:/^[A-Z]{6}\d{3}$/'],
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
        $cluster->delete();
        return redirect()->route('clusters.index')
            ->with('success', 'Cluster deleted successfully');
    }

}
