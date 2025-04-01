<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Course extends Model
{
    /** @use HasFactory<\Database\Factories\CourseFactory> */
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
        'nat_code',
        'nat_title',
        'nat_code_title',
    ];

    /**
     * Define a relationship to the parent
     */

    public  function packages():BelongsToMany
    {
        return $this->belongsToMany(Package::class);
    }

    public function clusters():HasMany
    {
        return $this->hasMany(Cluster::class);
    }
//    public  function units():HasMany
//    {
//        return $this->hasMany(Unit::class);
//    }

    public function units(): BelongsToMany
    {
        return $this->belongsToMany(Unit::class, 'course_unit')->withTimestamps();
    }
}
