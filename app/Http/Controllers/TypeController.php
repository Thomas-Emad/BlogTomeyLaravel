<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $types = Type::get();
        return view("pages.types_tags", compact(["types"]));
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
            'name' => ['required', 'min:3', "max:100", "unique:types"],
        ], [
            'name.required' => 'You must enter a new type name..',
            'name.min' => 'The type name must not be less than 3 letters long..',
            'name.max' => 'The type name must be no more than 100 characters long..',
            'name.unique' => 'That Name Is Exisit..',
        ]);

        Type::create([
            "name" => $request->name,
        ]);
        return back()->with('message', "Added successfully..");
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
        ], [
            'name.required' => 'You must enter a new type name..',
            'name.min' => 'The type name must not be less than 3 letters long..',
            'name.max' => 'The type name must be no more than 100 characters long..',
            'name.unique' => 'That Name Is Exisit..',
        ]);

        $type = Type::findOrFail($request->id);
        $type->update([
            'name' => $request->name,
        ]);
        return back()->with('message', "Editing successfully..");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        Type::destroy($request->id);
        return back()->with('message', "Deleteing successfully..");
    }
}
