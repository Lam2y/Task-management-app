<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'Task',
        'Description',
        'Date_Given',
        'Due_Date',
        'Priority',
        'Status',
        'Assigned_By', // Assuming Assigned_By is the foreign key for user_id
        'Assigned_By_Usertype'
    ];

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'Assigned_By');
    }
}
