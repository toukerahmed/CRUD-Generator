<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'descrioption', 'status'
    ];

    /**
     * Scope filters
     */
    public function scopeFilter($query, array $filters)
    {
        return $query
            ->when($filters['name'] ?? null, fn($q, $value) => $q->where('name', $value))
        ->when($filters['descrioption'] ?? null, fn($q, $value) => $q->where('descrioption', $value))
        ->when($filters['status'] ?? null, fn($q, $value) => $q->where('status', $value));
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}
