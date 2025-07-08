<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // public function index()
    public function index(Blog $blog)
    {

        // Fetch only comments belonging to this specific blog
        $comments = $blog->comments()->with('user')->get();

        return response()->json($comments, 201);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Blog $blog)
    {

        try {
            $validated = $request->validate(
                [
                    'content' => 'required|string'
                ]
            );

            // Create comment through the blog
            $comment = $blog->comments()->create([
                'content' => $validated['content'],
                'user_id' => auth()->id() // Associate with current user
            ]);

            return response()->json($comment, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating comment',
                'error' => $e->getMessage()
            ], 500);
        }
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
    public function update(Request $request, Comment $comment)
    {

        // Verify the authenticated user owns the comment
        if ($request->user()->id !== $comment->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $validated = $request->validate([
            'content' => 'required|string|max:2000',
        ]);

        $comment->update($validated);

        return response()->json($comment->load('user'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Comment $comment)
    {
        if ($request->user()->id !== $comment->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json(null, 204);
    }
}
