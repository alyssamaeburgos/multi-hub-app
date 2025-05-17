<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Models\Note;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::where('user_id', auth()->id())->get();
        return Inertia::render('Note/Index', [
            'notes' => $notes,
        ]);

        // return Inertia::render('NoteIndex', [
        //     'notes' => $notes,
        // ]);
    }
}
