<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Reply;
use Illuminate\Support\Facades\Auth;

class Post_replyController extends Controller
{
    public function index()
    {
        $posts = Post::with(['replies.user', 'user'])->get();
        //dd($posts);
        return view('contact', compact('posts'));
       
    }

    public function store(Request $request)
    {
        Post::create([
            'title' => $request->title,
            'content' => $request->content,
            'user_id' => Auth::id(),
            
        ]);

        return redirect()->route('site.contact')->with('success', 'Post created successfully!');
    }

    public function storeReply(Request $request)
    {
        Reply::create([
            'post_id' => $request->post_id,
            'reply_content' => $request->reply_content,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('site.contact')->with('success', 'Reply added successfully!');
    }
}
