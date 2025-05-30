<?php

namespace App\Http\Controllers\web;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BlogController extends Controller
{
    public function index()
    {
        $blogs = Blog::where('user_id', auth()->id())->get();

        return Inertia::render('Blog/Index', [
            'blogs' => $blogs,
        ]);
    }
}
