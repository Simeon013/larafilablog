<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'title',
        'description',
        'image',
        'url',
        'category',
        'technology_id',
        'is_primary',
    ];

    protected $casts = [
        'technology_id' => 'array',
    ];

    public function technology()
    {
        return $this->hasMany(Technology::class);
    }
}

class Technology extends Model
{
    protected $fillable = [
        'name',
        'slug',
    ];

    public function projects()
    {
        return $this->hasMany(Project::class);
    }
}
