<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TaskAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'Task',
        'Description',
        'Assigned_To',
        'Date_Given',
        'Due_Date',
        'Priority',
        'Status',
        'Assigned_By',
        'Assigned_By_Usertype'
    ];

    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'Assigned_To');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'Assigned_By');
    }
}
