<?php

namespace App\Http\Controllers;

use App\Enums\TaskStatus;
use App\Models\Task;
use App\Models\TaskAssignment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index(Request $request)
    {
        // Get the current authenticated user
        $currentUser = Auth::user();
    
        // Filter by status if provided
        $status = $request->input('status');
        
        // Query TaskAssignments where 'Assigned_To' matches the current user's name
        $taskAssignmentsQuery = TaskAssignment::where('Assigned_To', $currentUser->name)
                            
                            ->latest();
    
        // Query Tasks where 'Assigned_By' matches the current user's name, with 'assignedBy' relationship eager loaded
        $tasksQuery = Task::where('Assigned_By', $currentUser->name)
                      ->with('assignedBy')
                      
                      ->latest();
    
        // Paginate results
        $taskAssignments = $taskAssignmentsQuery->paginate(10);
        $tasks = $tasksQuery->paginate(10);
    
        // Optionally, you can combine the results or handle them separately
        return compact('taskAssignments', 'tasks');
    }

    public function store(Request $request)
    {

        // Parse and format dates using Carbon
        $dateGiven = Carbon::parse($request->Date_Given)->format('Y-m-d');
        $dueDate = Carbon::parse($request->Due_Date)->format('Y-m-d');
        
        // Create a new task
        $task = Task::create([
            'Task' => $request->Task,
            'Description' => $request->Description,
            'Date_Given' => $dateGiven,
            'Due_Date' => $dueDate,
            'Assigned_By' => Auth::user()->name,
            'Status' => $request->Status,
            'Priority' => $request->Priority,
            'Assigned_By_Usertype' => Auth::user()->usertype,
        ]);
        
        // Log the creation
        Log::info('Task created by ' . Auth::user()->name . ': ' . $task->id);
        
    
    }

    public function update(Task $task){
        // Update the task
        $task->update([
            'Task' => request('Task'),
            'Description' => request('Description'),
            'Date_Given' => request('Date_Given'),
            'Due_Date' => request('Due_Date'),
            'Priority' => request('Priority'),
            'Status' => request('Status'),
            'Assigned_By' => request('Assigned_By'),
            'Assigned_By_Usertype' => request('Assigned_By_Usertype'),
        ]);
        
        // Log the update
        Log::info('Task updated by ' . Auth::user()->name . ': ' . $task->id);
        return $task;
    }

    public function destroy(Task $task){
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
        $tasks = Task::where('Task', 'like', '%' . $search . '%')
                ->orWhere('Description', 'like', '%' . $search . '%')
                ->get();
        
        return $tasks;
    }

    public function groupTaskByEmployee(){
        // Group tasks by 'Assigned_To' and count the number of tasks for each employee
        $tasks = Task::select('Assigned_By')
                ->selectRaw('Status ,Priority, count(*) as count')
                ->groupBy('Status','Assigned_By','Priority')
                ->where('Status', 'Completed')
                ->get();
        
        $taskAssignments = TaskAssignment::select('Assigned_To')
                ->selectRaw('Status, Priority, count(*) as count')
                ->groupBy('Status','Assigned_To','Priority')
                ->where('Status', 'Completed')
                ->get();

        return compact('tasks', 'taskAssignments');
    }
}
