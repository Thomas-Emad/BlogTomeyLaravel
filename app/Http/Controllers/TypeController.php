<?php

namespace App\Http\Controllers;

use App\Models\Type;
use App\Models\Types_Articles;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class TypeController extends Controller
{
  function __construct()
  {
    $this->middleware(['permission:types']);
  }
  /**
   * Display a listing of the resource.
   */
  public function index()
  {
    $types = Type::get();
    $top_types = Types_Articles::select(DB::raw('count(*) as count'), 'id_type')->groupBy('id_type')->orderByDESC('count')->limit(5)->get();
    return view("pages.types", compact(["types", "top_types"]));
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
    $request->validate([
      'name' => ['required', 'min:3', "max:100", "unique:types,name"],
    ]);

    Type::create([
      "name" => $request->name,
    ]);
    return back()->with('message',  __("messages.types.add"));
  }

  /**
   * Display the specified resource.
   */
  public function show(Type $type)
  {
    //
  }

  /**
   * Show the form for editing the specified resource.
   */
  public function edit(Type $type)
  {
    //
  }

  /**
   * Update the specified resource in storage.
   */
  public function update(Request $request)
  {
    $request->validate([
      'name' => ['required', 'min:3', "max:100", "unique:types,name,$request->id"],
    ]);

    $type = Type::findOrFail($request->id);
    $type->update([
      'name' => $request->name,
    ]);
    return back()->with('message', __("messages.types.edit"));
  }

  /**
   * Remove the specified resource from storage.
   */
  public function destroy(Request $request)
  {
    Type::destroy($request->id);
    return back()->with('message', __("messages.types.delete"));
  }
}
