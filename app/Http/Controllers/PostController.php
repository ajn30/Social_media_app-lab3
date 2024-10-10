<?php
namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $post = new Post();
        $post->user_id = Auth::id();
        $post->content = $request->content;
        $post->save();

        return redirect()->route('dashboard')->with('success', 'Post created successfully.');
    }

    public function like(Post $post)
    {
        // Toggle the like status
        $user = Auth::user();
        $post->likes()->toggle($user);

        return redirect()->route('dashboard')->with('success', 'Post liked/unliked successfully.');
    }
}
