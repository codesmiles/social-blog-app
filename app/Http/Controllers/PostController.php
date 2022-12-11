<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Posts_model;
class PostController extends Controller
{
    public function store(Request $request)
    {
        $validate = $request->validate([
            'title' => 'required|string|min:3',
            'details' => 'required|string|min:3',
        ]);

        $post = Posts_model::create([
            'user_id' => auth()->user()->id,
            'title' => $request->title,
            'details' => $request->details,
        ]);

        return response()->json([
            "message" => "Post created",
            "post" => $post
        ], 201);
    }
}