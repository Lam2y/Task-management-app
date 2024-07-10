<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'usertype',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function tasksAssigned()
    {
        return $this->hasMany(TaskAssignment::class, 'Assigned_To');
    }

    public function tasksAssignedBy()
    {
        return $this->hasMany(Task::class, 'Assigned_By');
    }
}


