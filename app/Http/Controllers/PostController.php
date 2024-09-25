<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Inertia\Inertia;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        return Inertia::render('Posts/index', ['posts' => $posts]);
    }

    public function create()
    {
        return Inertia::render('Posts/create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'required|max:255',
            'body' => 'required',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('picture')) {
            $validated['picture'] = $request->file('picture')->store('post_pictures', 'public');
        }

        Post::create($validated);
        return redirect()->route('posts.index');
    }

    public function edit(Post $post)
    {
        return Inertia::render('Posts/edit', ['post' => $post]);
    }
  

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'excerpt' => 'required|max:255',
            'body' => 'required',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('picture')) {
            $validated['picture'] = $request->file('picture')->store('post_pictures', 'public');
        }

        $post->update($validated);
        return redirect()->route('posts.index');
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete($id);
        return response()->json(['message' => 'Post deleted successfully!']);
    }
}
