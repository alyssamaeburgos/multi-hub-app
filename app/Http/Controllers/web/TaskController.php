<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Task;

class TaskController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('Task/Index');
    }

    public function update($id)
    {
        $task = Task::findOrFail($id);

        return Inertia::render('Task/Edit', ['task' => $task ]);
    }

    public function show()
    {
        // $task = Task::all();

        // $tasks = Task::with('user')->get(); // Eager load the 'user' relationship

        // return Inertia::render('Task/Show', ['task' => $tasks ]);
    
        return Inertia::render('Task/Show');
    }
}
