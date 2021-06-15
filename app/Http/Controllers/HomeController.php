<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(): string
    {
        $posts = Post::where('status', '=', Post::IS_PUBLIC)->paginate(1);
        return view('pages.index')->with('posts', $posts);
    }
}
