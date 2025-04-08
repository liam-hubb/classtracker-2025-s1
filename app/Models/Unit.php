<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Unit extends Model
{
    /** @use HasFactory<\Database\Factories\UnitFactory> */
    use HasFactory;

    protected $fillable = [
        'national_code',
        'aqf_level',
        'title',
        'tga_status',
        'state_code',
        'nominal_hours',
        'type',
        'qa',
    ];

    public function clusters(): BelongsToMany
    {
        return $this->belongsToMany(Cluster::class);
    }

    public  function courses(): BelongsToMany
    {
        return $this->belongsToMany(Course::class, 'course_unit')->withTimestamps();
    }
}
