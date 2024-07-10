<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TaskAssignment;
use Illuminate\Support\Facades\Log;

class AdminTaskStatusController extends Controller
{
    public function getStatusWithCount()
    {
        $username = auth()->user()->name;
        // Query the counts for each status
        $completedCount = TaskAssignment::where('Status', 'Completed')->where('Assigned_By',  $username)->count();
        $inProgressCount = TaskAssignment::where('Status', 'In progress')->where('Assigned_By',  $username)->count();
        $assignedCount = TaskAssignment::where('Status', 'Assigned')->where('Assigned_By',  $username)->count();
        $lateCount = TaskAssignment::where('Status', 'Late')->where('Assigned_By',  $username)->count();
        $cancelledCount = TaskAssignment::where('Status', 'Cancelled')->where('Assigned_By',  $username)->count();
        $allCount=TaskAssignment::where('Assigned_By',  $username)->count();

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



    public function getAllStatusWithCount()
    {
        // Query the counts for each status
        $completedCount = TaskAssignment::where('Status', 'Completed')->count();
        $inProgressCount = TaskAssignment::where('Status', 'In progress')->count();
        $assignedCount = TaskAssignment::where('Status', 'Assigned')->count();
        $lateCount = TaskAssignment::where('Status', 'Late')->count();
        $cancelledCount = TaskAssignment::where('Status', 'Cancelled')->count();

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
            ]
        ];
    }
}
