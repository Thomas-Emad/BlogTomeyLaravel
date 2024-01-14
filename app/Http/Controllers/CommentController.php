<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
  public function store(Request $request, $id_user, $id)
  {
    $request->validate([
      'comment' => ['required', 'min:10']
    ]);
    Comment::create([
      'id_post' => $id,
      'id_user' => Auth::user()->id,
      'comment' => $request->comment,
    ]);
    return back()->with('message', __("messages.comment.add"));
  }
  public function refer(Request $request, $id_user, $id)
  {
    $request->validate([
      'refer' => ['required'],
      'comment' => ['required', 'min:10'],
    ]);
    Comment::create([
      'id_post' => $id,
      'id_user' => Auth::user()->id,
      'comment' => $request->comment,
      'refer' => $request->refer,
    ]);
    return back()->with('message', __("messages.comment.add"));
  }
  public function edit(Request $request)
  {
    $request->validate([
      'comment' => ['required', 'min:10']
    ]);
    $comment = Comment::findOrFail($request->id);
    $comment->update([
      'comment' => $request->comment
    ]);
    return back()->with('message', __("messages.comment.edit"));
  }

  public function destroy(Request $request)
  {
    Comment::destroy($request->id);
    return back()->with('message', __("messages.comment.delete"));
  }
}
