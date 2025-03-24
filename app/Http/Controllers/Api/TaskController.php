<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Task;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // $tasks = DB::table('tasks')->get();
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
            // 'user_id' => 'nullable|exists:users,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'status' => 'nullable|in:open,in progress,done',
        ]);

        // create a new task using the validated data
        // Task::create($validatedData);
        $task = Task::create([
            // 'user_id' => $request->input('user_id'),
            'user_id' => auth()->id(), // ✅ Get authenticated user ID
            'title' => $request->input('title'),
            'description' => $request->input('description'),
            'deadline' => $request->input('deadline'),
            'status' => $request->input('status', 'open'), // Default to 'open' if not provided
        ]);

        // redirect to a specific route with a success message
        // return redirect()->route('tasks.index')->with('success', 'Task created successfuly');

        return response()->json(['message' => 'Item created successfully', 'data' => $task], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
        //
    }
}
