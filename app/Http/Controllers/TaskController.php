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
        Log::info($request->getContent());

        // Validate incoming request
        $validatedData = $request->validate([
            'tasktitle' => 'required|string|max:50',
            'taskdescription' => 'nullable|string',
            'taskcompleted' => 'boolean',
        ]);

        // Create a new task entry
        $task = TaskEntry::create([
            'task_title' => $validatedData['tasktitle'],
            'task_description' => $validatedData['taskdescription'],
            'task_completed' => $request->has('taskcompleted') ? true : false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // Return JSON response
        return response()->json(['message' => 'Task created successfully', 'status' => true]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
