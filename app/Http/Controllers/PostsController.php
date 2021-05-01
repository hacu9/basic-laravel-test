<?php

namespace App\Http\Controllers;

use App\Http\Resources\Collections\PostCollection;
use App\Http\Resources\Models\PostResource;
use App\Models\Post;
use App\Http\Requests\PostRequest as Request;
use App\Traits\ApiResponser;

class PostsController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware('private.resource:post')->except(['store','index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $hidePrivate = $request->get('is_published', true);

        if(!auth()->check()){
            $hidePrivate = true;
        }

        return new PostCollection(Post::publishedStatus($hidePrivate)->withCount('comments')->with(['comments' => function ($query) {
            $query->orderBy('created_at', 'desc')->limit(5);
        }])->simplePaginate(15));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        return $this->success([
            'posts' => new PostResource($request->user()->posts()->create($request->only(['content', 'is_published', 'title', 'slug'])))
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Post $post)
    {
        return $this->success([
            'posts' => new PostResource($post)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $post->update($request->only(['content', 'is_published', 'title', 'slug']));

        return $this->success([
            'posts' => new PostResource($post)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Post $post)
    {
        $post->delete();
        return $this->success([
            'message' => 'Successfully Deleted'
        ]);
    }
}

