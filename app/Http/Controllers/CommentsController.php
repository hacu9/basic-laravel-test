<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Http\Requests\CommentRequest as Request;
use App\Http\Resources\Models\CommentResource;
use App\Traits\ApiResponser;


class CommentsController extends Controller
{
    use ApiResponser;

    public function __construct()
    {
        $this->middleware('private.resource:comment')->except(['store', 'index']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return $this->success([
            'data' => $request->user()->comments()->publishedStatus($request->get('is_published', true))->simplePaginate(15)
        ]);
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
            'comments' => new CommentResource($request->user()->comments()->create($request->only(['content', 'is_published', 'post_id'])))
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Comment $comment)
    {
        return $this->success([
            'comments' => new CommentResource($comment)
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Comment $comment)
    {
        $comment->update($request->only(['content', 'is_published', 'post_id']));

        return $this->success([
            'comments' => new CommentResource($comment)
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Comment $comment)
    {
        $comment->delete();

        return $this->success([
            'message' => 'Successfully Deleted'
        ]);
    }
}
