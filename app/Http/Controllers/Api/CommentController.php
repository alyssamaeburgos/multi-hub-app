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
    public function index()
    {
        $comments = Comment::with('user')->get();

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

            // // Create comment through the authenticated user
            // $comment = auth()->user()->comments()->create([
            //     'content' => $validated['content'],
            //     'blog_id' => $blog->id // Associate with the blog
            // ]);

            return response()->json($comment, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating comment',
                'error' => $e->getMessage()
            ], 500);
        }
        // $request->validate([
        //     'content' => 'required|string'
        // ]);

        // $comment = $blog->comments()->create([
        //     'user_id' => auth()->id(),
        //     'content' => $request->content
        // ]);

        // return response()->json($comment, 201);
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
    public function update(Request $request, string $id, Comment $comment)
    {
        $request->validate([
            'content' => 'required|string',
        ]);

        $comment->update($request->all());

        return response()->json($comment);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        $comment->delete();

        return response()->json(null, 204);
    }
}
