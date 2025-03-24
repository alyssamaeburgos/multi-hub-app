<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class TaskController extends Controller
{
    //
    public function index()
    {
        return Inertia::render('Task/Index');
    }
}
