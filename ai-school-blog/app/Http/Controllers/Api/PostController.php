<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PostController extends Controller
{
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'author' => 'nullable|string|max:100',
            'stance' => ['required', Rule::in(['pro','con','neutral'])],
            'tags' => 'nullable|array',
            'tags.*' => 'string|max:50',
            'published_at' => 'nullable|date',
        ]);

        $post = Post::create($data);

        return response()->json([
            'message' => 'Post created',
            'post' => $post
        ], 201);
    }

    public function index(Request $request)
    {
        $query = Post::query();

        if ($request->filled('stance')) {
            $query->where('stance', $request->query('stance'));
        }

        if ($request->filled('author')) {
            $query->where('author', 'like', '%'.$request->query('author').'%');
        }

        if ($request->filled('tag')) {
            $tag = $request->query('tag');
            $query->whereJsonContains('tags', $tag);
        }

        if ($request->filled('from') || $request->filled('to')) {
            if ($request->filled('from')) {
                $query->where('published_at', '>=', $request->query('from'));
            }
            if ($request->filled('to')) {
                $query->where('published_at', '<=', $request->query('to'));
            }
        }

        $posts = $query->orderBy('published_at', 'desc')->paginate(12);

        return response()->json($posts);
    }

    public function show(Post $post)
    {
        return response()->json($post);
    }

    public function filterByStance(Request $request, $stance)
    {
        $request->validate(['stance' => Rule::in(['pro','con','neutral'])]);
        return response()->json(Post::where('stance', $stance)->orderBy('published_at','desc')->get());
    }

    public function filterByAuthor($author)
    {
        return response()->json(Post::where('author','like','%'.$author.'%')->get());
    }

    public function filterByTag($tag)
    {
        return response()->json(Post::whereJsonContains('tags', $tag)->get());
    }
}