<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::paginate(6);
        return view('courses.index', compact(['courses', ]));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('courses.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'national_code' => ['required', 'string', 'regex:/^[A-Z]{3}\d{5}$/'],
            'aqf_level' => ['required', 'min:5', 'max:255', 'string',],
            'title' => ['required', 'min:5', 'max:255', 'string',],
            'tga_status' => ['required', 'min:5', 'max:255', 'string',],
            'state_code' => ['required', 'string', 'size:4'],
            'nominal_hours' => ['required', 'min:1', 'max:2000', 'numeric',],
            'type' => ['required', 'min:5', 'max:255', 'string',],
            'qa' => ['sometimes', 'nullable','string', 'size:4'],
            'nat_code' => ['sometimes', 'nullable','string', 'regex:/^[A-Z]{3}\d{5}$/'],
            'nat_title' => ['sometimes', 'nullable','min:5', 'max:255', 'string',],
            'nat_code_title' => ['required','min:5', 'max:255', 'string',],
        ]);


        $validated['qa'] = $validated['qa'] ?: $validated['state_code'];
        $validated['nat_code'] = $validated['nat_code'] ?: $validated['national_code'];
        $validated['nat_title'] = $validated['nat_title'] ?: $validated['title'];

        Course::create($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Course created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $course = Course::whereId($id)->get()->first();

        if ($course) {
            return view('courses.show', compact(['course',]))
                ->with('success', 'Course found')
                ;
        }

        return redirect(route('courses.index'))
            ->with('warning', 'Course not found');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        return view('courses.edit', compact('course'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validated = $request->validate([
            'national_code' => ['required', 'string', 'regex:/^[A-Z]{3}\d{5}$/'],
            'aqf_level' => ['required', 'min:5', 'max:255', 'string',],
            'title' => ['required', 'min:5', 'max:255', 'string',],
            'tga_status' => ['required', 'min:5', 'max:255', 'string',],
            'state_code' => ['required', 'string', 'size:4'],
            'nominal_hours' => ['required', 'min:1', 'max:2000', 'numeric',],
            'type' => ['required', 'min:5', 'max:255', 'string',],
            'qa' => ['sometimes', 'nullable','string', 'size:4'],
            'nat_code' => ['sometimes', 'nullable','string', 'regex:/^[A-Z]{3}\d{5}$/'],
            'nat_title' => ['sometimes', 'nullable','min:5', 'max:255', 'string',],
            'nat_code_title' => ['required','min:5', 'max:255', 'string',],
        ]);

        $validated['qa'] = $validated['qa'] ?: $validated['state_code'];
        $validated['nat_code'] = $validated['nat_code'] ?: $validated['national_code'];
        $validated['nat_title'] = $validated['nat_title'] ?: $validated['title'];

        Course::whereId($id)->update($validated);

        return redirect()->route('courses.index')
            ->with('success', 'Course updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('courses.index')
            ->with('success', 'Course deleted successfully');
    }
}
