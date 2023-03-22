<?php

namespace App\Http\Controllers;
use App\Interfaces\CommentInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Exceptions\GenericExceptions;

class CommentsController extends Controller
{
    private $commentInterface;
    public function __construct(CommentInterface $commentInterface)
    {
        $this->commentInterface = $commentInterface;
    }

    public function index()
    {
        $reply = $this->commentInterface->index();

        return response()->json([
            "message" => $reply,
        ]);
    }

    public function save(Request $request, $post_id)
    {
        $request->validate([
            'comment' => 'required|string|min:3'
        ]);
        $user_id = auth()->user()->id;
        $entry = $this->commentInterface->save($request->comment, $user_id, $post_id);
        
    
        return response()->json([
            "message" => "successful",
            "comment" => $entry,
        ], Response::HTTP_CREATED);
    }
        
    
}
