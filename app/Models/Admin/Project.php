<?php
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = ['name', 'descrioption', 'status'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}