<?php

namespace App\Http\Controllers;

use App\Models\TaskAssignment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AdminTaskController extends Controller
{
    public function index(Request $request)
    {
        // Get the current authenticated user
        $currentUser = Auth::user();
    
        // Filter by status if provided
        $status = $request->input('status');
        
        // Query TaskAssignments where 'Assigned_To' matches the current user's name
        $taskAssignmentsQuery = TaskAssignment::where('Assigned_By', $currentUser->name)
                            
                            ->latest();
    
        // Paginate results
        $taskAssignments = $taskAssignmentsQuery->paginate(10);
       
    
        // Optionally, you can combine the results or handle them separately
        return compact('taskAssignments', );
    }

    public function store(Request $request)
    {

        // Parse and format dates using Carbon
        $dateGiven = Carbon::parse($request->Date_Given)->format('Y-m-d');
        $dueDate = Carbon::parse($request->Due_Date)->format('Y-m-d');
        
        // Create a new task
        $task = TaskAssignment::create([
            'Task' => $request->Task,
            'Description' => $request->Description,
            'Date_Given' => $dateGiven,
            'Due_Date' => $dueDate,
            'Assigned_By' => Auth::user()->name,
            'Assigned_To' => $request->Assigned_To,
            'Status' => $request->Status,
            'Priority' => $request->Priority,
            'Assigned_By_Usertype' => Auth::user()->usertype,
        ]);
        
        // Log the creation
        Log::info('Task created by ' . Auth::user()->name . ': ' . $task->id);
        
    
    }

    public function update(TaskAssignment $task){
        // Update the task
        $task->update([
            'Task' => request('Task'),
            'Description' => request('Description'),
            'Date_Given' => request('Date_Given'),
            'Due_Date' => request('Due_Date'),
            'Priority' => request('Priority'),
            'Status' => request('Status'),
            'Assigned_To' => request('Assigned_To'),
            'Assigned_By' => request('Assigned_By'),
            'Assigned_By_Usertype' => request('Assigned_By_Usertype'),
        ]);
        
        // Log the update
        Log::info('Task updated by ' . Auth::user()->name . ': ' . $task->id);
        return $task;
    }

    public function destroy(TaskAssignment $task){
        // Delete the task
        $task->delete();
        
        // Log the deletion
        Log::info('Task deleted by ' . Auth::user()->name . ': ' . $task->id);
        return response()->noContent();
    }

    public function search(){
        // Get the search query
        $search = request('search');
        
        // Search for tasks where the task name or description contains the search query
        $tasks = TaskAssignment::where('Task', 'like', '%' . $search . '%')
                ->orWhere('Description', 'like', '%' . $search . '%')
                ->get();
        
        return $tasks;
    }
}
