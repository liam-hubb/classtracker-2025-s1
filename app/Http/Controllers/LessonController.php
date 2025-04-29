<?php

namespace App\Http\Controllers;

use App\Models\Clusters;
use App\Models\Lesson;
use App\Http\Requests\StoreLessonRequest;
use App\Http\Requests\UpdateLessonRequest;
use Carbon\Carbon;

class LessonController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Lesson::orderBy('name', 'asc')->paginate(6);
        return view('lessons.index', compact(['data']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Lesson $lesson)
    {
        $clusters = Clusters::all();
        $staffs = User::whereHas('staff')->get();
        $students = User::whereHas('student')->get();

        return view('lessons.create', compact(['clusters', 'staffs', 'students', 'lesson']));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLessonRequest $request, Lesson $lesson)
    {
        $input = $request->validated();

        if (!empty($input['start_time'])) {
            $input['start_time'] = Carbon::createFromFormat('H:i', $input['start_time'])->format('H:i');
        }

        $lesson = Lesson::create($input);

        // Synchronising associated users
        $staffIds = $request->input('staff_ids', []);
        $studentIds = $request->input('student_ids', []);
        $allUserIds = array_unique(array_merge($staffIds, $studentIds));

        $lesson->users()->sync($allUserIds);

        return redirect()->route('lessons.index')
            ->with('success', 'Lesson created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Lesson $lesson)
    {
        $lesson = Lesson::with(['staff','students',])->where('id',$lesson->id)->first();
//        dd($lesson);
     return view('lessons.show', compact('lesson'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Lesson $lesson)
    {
        $clusters = Clusters::all();
        $staffs = User::whereHas('staff')->get();
        $students = User::whereHas('student')->get();

        return view('lessons.edit', compact(['lesson', 'clusters', 'students', 'staffs']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLessonRequest $request, Lesson $lesson)
    {
        $input = $request->validated();
        if (!empty($input['start_time'])) {
            $input['start_time'] = Carbon::createFromFormat('H:i', $input['start_time'])->format('H:i');
        }

        $lesson->update($input);

        // Synchronising associated users
        $staffIds = $request->input('staff_ids', []);
        $studentIds = $request->input('student_ids', []);
        $allUserIds = array_unique(array_merge($staffIds, $studentIds));

        $lesson->users()->sync($allUserIds);

        return redirect()->route('lessons.index')
            ->with('success', 'Lesson updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Lesson $lesson)
    {
        $lesson->delete();
        return redirect()->route('lessons.index')
            ->with('success', 'Lesson deleted successfully');
    }
}
