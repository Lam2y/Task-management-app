<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use App\Models\Task; // Make sure to import your Task model
use App\Models\TaskAssignment; // Make sure to import your TaskAssignment model
use Illuminate\Http\Request;

class TaskStatusController extends Controller
{
    public function getStatusWithCount()
    {
        $username = auth()->user()->name;
        // Query the counts for each status
        $completedCount = Task::where('Status', 'Completed')->where('Assigned_By',  $username)->count()+TaskAssignment::where('Status', 'Completed')->where('Assigned_To',  $username)->count();
        $inProgressCount = Task::where('Status', 'In progress')->where('Assigned_By',  $username)->count()+TaskAssignment::where('Status', 'In progress')->where('Assigned_To',  $username)->count();
        $assignedCount = Task::where('Status', 'Assigned')->where('Assigned_By',  $username)->count()+TaskAssignment::where('Status', 'Assigned')->where('Assigned_To',  $username)->count();
        $lateCount = Task::where('Status', 'Late')->where('Assigned_By',  $username)->count()+TaskAssignment::where('Status', 'Late')->where('Assigned_To',  $username)->count();
        $cancelledCount = Task::where('Status', 'Cancelled')->where('Assigned_By',  $username)->count()+TaskAssignment::where('Status', 'Cancelled')->where('Assigned_To',  $username)->count();
        $allCount=$completedCount+$inProgressCount+$assignedCount+$lateCount+$cancelledCount;
        return [
            [
                'name' => 'Completed', // Changed 'Complete' to 'Completed
                'count' => $completedCount
            ],
            [
                'name' => 'In progress',
                'count' => $inProgressCount
            ],
            [
                'name' => 'Assigned',
                'count' => $assignedCount
            ],
            [
                'name' => 'Late',
                'count' => $lateCount
            ],
            [
                'name' => 'Cancelled',
                'count' => $cancelledCount
            ],
            [
                'name' => 'All',
                'count' => $allCount]
        ];
    }
}
