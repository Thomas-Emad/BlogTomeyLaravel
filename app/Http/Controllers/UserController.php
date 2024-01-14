<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\File;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\DB;


class UserController extends Controller
{
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $users = User::all();
    return view('pages.admin.users', compact(['users']));
  }

  /**
   * Show the form for creating a new resource.
   */
  public function create()
  {
    //
  }

  /**
   * Store a newly created resource in storage.
   */
  public function store(Request $request)
  {
    //
  }

  /**
   * Display the specified resource.
   */
  public function show($id = null)
  {
    if ($id == null) {
      $id = \Auth::user()->id;
    }
    $user = User::findOrFail($id);
    return view("pages.profile", compact(['user']));
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit($id)
  {
    $user = User::find($id);
    $roles = Role::pluck('name', 'name')->all();
    $userRole = $user->roles->pluck('name', 'name')->all();
    return view('pages.admin.editRolesUser', compact('user', 'roles', 'userRole'));
  }
  public function updateRoles(Request $request)
  {
    $this->validate($request, [
      'id' => 'required',
    ]);
    $user = User::findOrFail($request->input("id"));

    // Updating Roles
    DB::table('model_has_roles')->where('model_id', $request->input("id"))->delete();
    $user->assignRole($request->input("roles"));
    return redirect("/admin/users")->with('message',  __("messages.user.role"));
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request)
  {
    $request->validate([
      'name' => ['required', 'min:3', "max:20"],
      'info' => ['required', 'min:3', "max:256"],
      'file' => [File::types(['png', 'jpg', 'jpeg', 'webp'])],
    ]);

    // Move Bg If Exisit
    if ($request->hasFile("file")) {
      @unlink("files/" . \Auth::user()->img);
      $file = $request->file('file')->hashName();
      $bgFile = $request->file->move(public_path('files/'), $file);
    }

    \Auth::user()->update([
      'name' => $request->name,
      'info' => $request->info,
      'password' => $request->filled('password') ? Hash::make($request->password) : \Auth::user()->password,
      'img' => $request->hasFile('file') ? $file : \Auth::user()->img
    ]);
    return back()->with("message",  __("messages.user.update"));
  }

  public function follow($id)
  {
    if (User::findOrFail($id)) {
      $folowStatus = \Auth::user()->follow->where('id_author', $id)->first();
      if ($folowStatus) {
        $folowStatus->delete();
        return back()->with("message",  __("messages.user.unfollow"));
      } else {
        \Auth::user()->follow()->create([
          'id_author' => $id,
          'id_user' => \Auth::user()->id
        ]);
        return back()->with("message",  __("messages.user.follow"));
      }
    }
  }
  /**
   * Remove the specified resource from storage.
   */
  public function destroy($id)
  {
    if (\Auth::user()->can('users') || \Auth::user()->id == $id) {
      $user = User::findOrFail($id);
      @unlink("files/" . $user->img);
      DB::table("notifications")->where("notifiable_id", $user->id)->orWhere("data->id_author", $user->id)->delete();
      $user->delete();

      if (\Auth::user()->id == $id) {
        $request->session()->forget($session);
      }

      return back()->with('message',  __("messages.user.delete"));
    }
    return back()->with('message',  __("messages.user.canotdelete"));
  }

  public function banned($id)
  {
    if (true) {
      $user = User::findOrFail($id);
      if ($user->status == 'open') {
        $user->update([
          'status' => 'block',
        ]);
      } else {
        $user->update([
          'status' => 'open',
        ]);
      }
      return back()->with('message',  __("messages.user.banned"));
    }
  }

  public function notifReadAll()
  {
    \Auth::user()->notifications->markAsRead();
    return back();
  }
}
