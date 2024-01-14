<?php

namespace App\Http\Controllers;

use App\Models\Reaction;
use Illuminate\Http\Request;

class ReactionController extends Controller
{
  public function __invoke($user, $id, $code)
  {
    $user_id = \Auth::user()->id;
    $action = Reaction::where([['id_user', $user_id], ['id_article', $id]])->first();

    if (empty($action)) {
      if (in_array($code, [0, 1])) {
        Reaction::create([
          'id_user' => $user_id,
          'id_article' => $id,
          'action' => $code
        ]);
      }
      return back()->with('message', __("messages.reaction.add"));
    } else {
      $action->delete();
      if ($action->action == $code) {
        return back()->with('message', __("messages.reaction.delete"));
      } else {
        Reaction::create([
          'id_user' => $user_id,
          'id_article' => $id,
          'action' => $code
        ]);
        return back()->with('message', __("messages.reaction.add"));
      }
    }
  }
}
