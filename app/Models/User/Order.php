<?php
namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['name', 'status'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }
}