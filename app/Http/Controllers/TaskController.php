<?php

namespace App\Http\Controllers;

use App\Models\TaskEntry;
use Illuminate\Console\View\Components\Task;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

/**
 * -----------------
 * Task Controller
 * -----------------
 *
 * Task Controller to handle CRUD
 * functionality for Tasks
 *
 * Created using --resource
 *
 * @author creator-solutions/owen
 */
class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Retrieve the tasks in an associative array
        $tasks = TaskEntry::all();
        return view('task', compact('tasks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        try {
            // Validate incoming request
            $validatedData = $request->validate([
                'tasktitle' => 'required|string|max:50',
                'taskdescription' => 'nullable|string',
                'taskcompleted' => 'boolean',
            ]);

            // Extra validation check according validate rule
            if (strlen($validatedData['taskdescription']) > 255) {
                return response()->json(['message' => 'Task description must not exceed 255 characters', 'status' => false], 422);
            }

            //Check if a task already exists to cater for duplication of records
            if (TaskEntry::where('task_title', $validatedData['tasktitle'])->exists()) {
                return response()->json(['message' => 'Task title already exists', 'status' => false], 200);
            }

            // Create a new task entry
            $task = TaskEntry::create([
                'task_title' => $validatedData['tasktitle'],
                'task_description' => $validatedData['taskdescription'],
                'task_completed' => $request->has('taskcompleted') ? true : false,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Check if task is populated
            if ($task) {
                // Return JSON response
                return response()->json(['message' => 'Task created successfully', 'status' => true]);
            } else {
                return response()->json(['message' => 'Failed to create task', 'status' => false], 500);
            }
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Could not create task', 'status' => false], 500);
            Log::info($ex->getMessage());
        }
    }

    /**
     * Custom function to locate the specific entry
     * in the database
     *
     * @param string $id
     * @return void
     */
    public function find(string $id)
    {
        try {
            $task = TaskEntry::findOrFail($id);
            return response()->json(['message' => 'Task found successfully', 'task' => $task, 'status' => true]);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Could not find task', 'status' => false]);
            Log::info($ex->getMessage());
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Validate incoming request
            $validatedData = $request->validate([
                'tasktitle' => 'required|string|max:50',
                'taskdescription' => 'nullable|string',
                'taskcompleted' => 'boolean',
            ]);

            // Find the task by ID
            $task = TaskEntry::findOrFail($id);

            // Update task attributes
            $task->task_title = $validatedData['tasktitle'];
            $task->task_description = $validatedData['taskdescription'];
            $task->task_completed = $request->has('taskcompleted') && $request->input('taskcompleted') == '1';
            // Save the updated task
            $task->save();

            return response()->json(['message' => 'Task updated successfully', 'status' => true]);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Could not update task', 'status' => false]);
            Log::info($ex->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $task = TaskEntry::findOrFail($id);
            $task->delete();

            return response()->json(['message' => 'Task deleted successfully', 'status' => true]);
        } catch (\Exception $ex) {
            return response()->json(['message' => 'Could not delete task', 'status' => false]);
            Log::info($ex->getMessage());
        }
    }
}
