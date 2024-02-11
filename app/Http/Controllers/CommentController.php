<?php
namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index($feedbackId)
    {
        $comments = Comment::where('feedback_id', $feedbackId)->with('feedback','user')->get();
        return response()->json($comments);
    }

    public function store(Request $request)
    {
        $request->validate([
            // 'user_id' => 'required',
            'content' => 'required',
        ]);

        $comment = Comment::create([
            'user_id' => $request->user_id,
            'feedback_id' => $request->feedback_id,
            'content' => $request->content,
        ]);

        return response()->json($comment, 201);
    }

    public function update(Request $request, $id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $request->validate([
            'user_id' => 'required|exists:users,id',
            'content' => 'required',
        ]);

        $comment->update([
            'user_id' => $request->user_id,
            'content' => $request->content,
        ]);

        return response()->json($comment);
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);

        if (!$comment) {
            return response()->json(['message' => 'Comment not found'], 404);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted']);
    }
}
