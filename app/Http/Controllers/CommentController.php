<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Comment;
class CommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function blogCreate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'body' => 'required|string',
            'blog_id' => 'required|int|exists:blogs,id',
            'parent_id' => 'nullable|int|exists:comments,id'
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'message'   => 'Comment failed to post',
                'error'     => 1
            ]);
        }

        $comment = new Comment;
        $comment->body = $request->input('body');
        $comment->user_id = auth()->user()->id;
        $comment->commentable_type = 'App\Blog';
        $comment->commentable_id = $request->input('blog_id');
        if($request->filled('parent_id'))
        {
            $comment->parent_id = $request->input('parent_id');
        }

        $comment->save();


        if($request->filled('parent_id'))
        {
            return response()->json([
                'message'   => 'Comment Posted',
                'body'     => $request->input('body'),
                'parent_id' => $request->parent_id,
                'comment_id' => $comment->id,
                'isChild' => true,
                'error'     => 0
            ]);
        }
        return response()->json([
            'message'   => 'Comment Posted',
            'body'     => $request->input('body'),
            'blog_id' => $request->input('blog_id'),
            'parent_id' => $comment->id,
            'isChild' => false,
            'error'     => 0
        ]);
    }

    public function blogDelete(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'comment_id' => 'required|int'
        ]);

        if ($validator->fails())
        {
            return response()->json([
                'message'   => 'Comment was unable to delete',
                'error'     => 1
            ]);
        }

        $comment = Comment::find($request->comment_id);

        if($comment->user_id == auth()->user()->id)
        {
            DB::table('comments')->where('parent_id','=',$comment->id)->delete();
            $comment->delete();
            return response()->json([
                'message'   => 'Comment was deleted',
                'comment_id' => $comment->id,
                'error'     => 0
            ]);
        }
        return response()->json([
            'message'   => 'Comment was unable to delete',
            'error'     => 1
        ]);

    }
}









