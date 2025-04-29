<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    /** @use HasFactory<\Database\Factories\LessonFactory> */
    use HasFactory;

    protected $fillable = [
        'course_id',
        'cluster_id',
        'name',
        'start_date',
        'start_time',
        'weekday',
        'end_date',
        'duration'
    ];

    public function clusters()
    {
        return $this->belongsTo(Clusters::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'lesson_user');
    }

    public function staff()
    {
        return $this->users()->whereHas('roles', function ($query) {
            $query->where('name', 'Staff');
        });
    }

    public function students()
    {
        return $this->users()->whereHas('roles', function ($query) {
            $query->where('name', 'Student');
        });
    }

}
