<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Note;
use Illuminate\Support\Facades\Validator;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notes = Note::with('user')->get();

        return $notes;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validated the request data
        $validatedData = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            // 'date_created' => 'nullable|date',
            // 'date_modified' => 'nullable|date',
        ]);

        // $notes = Note::create([
        //     'user_id' => auth()->id(), // ✅ Get authenticated user ID
        //     'title' => $request->input('title'),
        //     'content' => $request->input('content'),
        //     'date_created' => $request->input('date_created'),
        // ]);

        $notes = Note::create([
            'user_id' => auth()->id(),
            'title' => $validatedData['title'],
            'content' => $validatedData['content'] ?? null,
            'date_created' => $validatedData['date_created'] ?? now(),
            'date_modified' => $validatedData['date_modified'] ?? null,
        ]);

        // redirect to a specific route with a success message
        return response()->json(['message' => 'Note created successfully', 'data' => $notes], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, string $id)
    {
        $notes = Note::find($id);

        if (!$notes) {
            return response()->json(['message' => 'Notes not found', 404]);
        }

        return response()->json($notes);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validatedData = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'date_modified' => 'nullable|date',
        ]);

        if ($validatedData->fails()) {
            return response()->json(['errors' => $validatedData->errors(), 422]);
        }

        // $data = $validatedData->validated(); // get only the validated fields

        $notes = Note::find($id);

        if (!$notes) {
            return response()->json(['message' => 'Note not found', 404]);
        };

        // $notes->update($request->all());

        // $notes->update([
        //     'title' => $request->input('title'),
        //     'content' => $request->input('content'),
        //     'date_modified' => now(), // override to current date & time
        // ]);

        // $notes->update([
        //     'title' => $validatedData['title'],
        //     'content' => $validatedData['content'],
        //     'date_modified' => now(), // Update date_modified
        // ]);

        // Update the note, including the 'date_modified' if it's provided
        $notes->update(array_merge($validatedData->validated(), [
            'date_modified' => now(), // Set 'date_modified' to the current time
        ]));


        return response()->json([
            'message' => 'Note updated successfully!',
            'notes' => $notes,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
