<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Package;
use App\Http\Requests\StorePackagesRequest;
use App\Http\Requests\UpdatePackagesRequest;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $packages = Package::paginate(10);
        return view('packages.index', compact(['packages']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $courses = Course::all();
        $package = new Package();
        return view('packages.create',compact(['courses', 'package' ]));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)

            {
        $validated = $request->validate([
            'national_code' => ['required', 'string', 'size:3',  'regex:/^[A-Z]/'],
            'title' => ['required', 'min:5', 'max:255', 'string',],
            'tga_status' => ['required', 'min:5', 'max:255', 'string',],

        ]);

        $package = Package::create($validated);

        foreach ($request->course_ids as $course_id) {
            $course = Course::whereId($course_id);
            $course->update(['package_id' => $package->id]);
        }

        return redirect()->route('packages.index')
            ->with('success', 'Package created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Package $package)
    {
        {

            $courses = $package->courses;
            if ($package) {
                return view('packages.show', compact(['package', 'courses']))
                    ->with('success', 'Package found')
                    ;
            }

            return redirect(route('packages.index'))
                ->with('warning', 'Package not found');
        }    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Package $package)
    {
        $courses = Course::all();
        return view('packages.edit', compact('package', 'courses'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Package $package)
    {

        $validated = $request->validate([
            'national_code' => ['required', 'string', 'size:3',  'regex:/^[A-Z]/'],
            'title' => ['required', 'min:5', 'max:255', 'string',],
            'tga_status' => ['required', 'min:5', 'max:255', 'string',],
        ]);

        $oldCourses = Course::all()->where('package_id', $package->id);
        foreach ($oldCourses as $oldCourse) {
            $oldCourse->update(['package_id' => null]);
        }

        foreach ($request->course_ids as $course_id) {
            $course = Course::whereId($course_id);
            $course->update(['package_id' => $package->id]);
        }

        $package->update($validated);

        return redirect()->route('packages.index')
            ->with('success', 'Package updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route('packages.index')
            ->with('success', 'Package deleted successfully');
    }
}
