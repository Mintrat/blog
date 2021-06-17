<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Tag;
use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $posts = Post::where('status', '=', Post::IS_PUBLIC)->paginate(10);
        return view('pages.index', compact('posts'));
    }

    public function show($slug)
    {
        $post = Post::where('slug', '=', $slug)->firstOrFail();
        return view('pages.show', compact('post'));
    }

    public function postsByTag($slug)
    {
        $tag = Tag::where('slug', '=', $slug)->firstOrFail();
        $posts = $tag->posts()->where('status', '=', Post::IS_PUBLIC)->paginate(10);
        return view('pages.list', compact('posts'));
    }

    public function postByCategory($slug)
    {
        $category = Category::where('slug', '=', $slug)->firstOrFail();
        $posts = $category->posts()->where('status', '=', Post::IS_PUBLIC)->paginate(10);
        return view('pages.list', compact('posts'));
    }
}
