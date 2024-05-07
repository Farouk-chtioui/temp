<?php

namespace App\Http\Controllers;

use App\Models\post;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = post::latest()->paginate(5);

        return View('post.index', compact('posts'));
    }

    public function create(): View
    {
        return view('post.create');
    }

    public function store(Request $request)
    {
        // Validate Form
        $this->validate($request ,[
            'title'   => 'required',
            'content' => 'required',
        ]);

        // Create Data
        Post::create([
            'title'     => $request->title,
            'content'   => $request->content
        ]);

        return redirect()->route('posts.index')->with(['success'=> 'Data Has Been Saved!']);
    }

    public function show(string $id): View
    {
        $post = Post::findOrFail($id);

        return view('post.show', compact('post'));
    }

    public function edit(string $id): View
    {
        $post = Post::findOrFail($id);

        return view('post.edit', compact('post'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $this->validate($request ,[
            'title'   => 'required',
            'content' => 'required',
        ]);

        $post = Post::findOrFail($id);

        $post->update([
            'title'     => $request->title,
            'content'   => $request->content
        ]);

        return redirect()->route('posts.index')->with(['success'=> 'Data Updated']);
    }

    public function destroy($id): RedirectResponse
    {
        $post = Post::findOrFail($id);

        $post->delete();

        return redirect()->route('posts.index')->with(['success'=> 'Data Deleted']);
    }
}