<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $blogs = Blog::with('user')->where('visibility', 'public')->get();

        return response()->json($blogs, 201);
    }

    public function userBlogs(Request $request)
    {
        // $request->user() will return the authenticated User model instance
        // if the 'auth:sanctum' middleware has successfully authenticated the request.
        $user = $request->user();

        // Check if a user is authenticated (though 'auth:sanctum' already handles this)
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated', 401]);
        }

        // Now you can confidently call the blogs() relationship on the user
        $blogs = $user->blogs()->latest()->get();

        return response()->json($blogs);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'content' => 'required|string',
                'visibility' => 'required|in:public, private'
            ]);

            // Create blog with authenticated user
            $blog = $request->user()->blogs()->create($validated);

            return response()->json($blog, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error creating blog',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Blog $blog)
    {
        // Check if blog is public or user owns it
        if ($blog->visibility !== 'public' && auth()->id() !== $blog->user_id) {
            abort(403);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Blog $blog)
    {
        // $this->authorize('update', $blog);

        $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'visibility' => 'required|in:public, private'
        ]);

        $blog->update($request->all());

        return response()->json($blog);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Blog $blog, Request $request)
    {
        if ($request->user()->id !== $blog->user_id) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        // $this->authorize('delete', $blog);

        $blog->delete();

        return response()->json(null, 204);
    }
}
