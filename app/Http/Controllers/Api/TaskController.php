<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Task;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;
// use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('user')->get(); // Eager load the 'user' relationship

        return $tasks;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validated the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'status' => 'nullable|in:open,in progress,done',
        ]);

        $task = Task::create([
            'user_id' => auth()->id(), // ✅ Get authenticated user ID
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'deadline' => $validatedData['deadline'],
            // 'status' => $validatedData(['status', 'open']), // Default to 'open' if not provided
            'status' => $validatedData['status'] ?? 'open', // ✅ Fallback to 'open' if null
        ]);

        // redirect to a specific route with a success message
        return response()->json(['message' => 'Item created successfully', 'data' => $task], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found', 404]);
        }

        return response()->json($task);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validated the request data
        $validatedData = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'status' => 'nullable|in:open,in progress,done',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors(), 422]);
        }

        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Product not found', 404]);
        };

        $task->update($request->all());

        return response()->json([
            'message' => 'Task updated successfully!',
            'task' => $task,
            'redirect' => route('tasks.show'), // Send the redirect URL as data
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::find($id);

        if (!$task) {
            return response()->json(['message' => 'Task not found'], 404);
        }

        $task->delete();

        return response()->json(['message' => 'Task deleted successfully']);
    }
}
