<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

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

    public function clusters(): hasMany
    {
        return $this->hasMany(Cluster::class);
    }

    public  function courses(): BelongsTo
    {
        return $this->belongsTo(Course::class);
    }
}
