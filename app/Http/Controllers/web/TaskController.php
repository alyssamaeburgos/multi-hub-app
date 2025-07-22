<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Task;

class TaskController extends Controller
{
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
        return Inertia::render('Task/Show');
    }

    public function calendar()
    {
        return Inertia::render('Task/Calendar');
    }
}