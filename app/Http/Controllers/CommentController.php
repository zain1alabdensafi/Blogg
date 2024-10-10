<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{
    public function create_comment(Request $request)
    {
        $data = Validator::make($request->all(),[
            'comment' => 'required',
            'post_id' => 'required'
        ]);
        if ($data->fails())
        {
            return response()->json([
            'message'=> $data->errors(),
            'status'=> 400
        ]);
        }
        $imageUrl= null;
        if ($request->hasFile('image'))
         {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $path = $image->storeAs('public/post/comments/images/', $imageName);
            $imageUrl = Storage::url($path);
        
        }
        $videoUrl = null;
        if($request->hasFile('video'))
        {   
            $video = $request->file('video');
            $videoName = time() . '.' . $video->getClientOriginalExtension();
            $path = $video->storeAs('public/post/comments/videos/', $videoName);
            $videoUrl = Storage::url($path);
        }
        $comment = Comment::create([
            'comment' => $request['comment'],
            'image' => $imageUrl ?? null,
            'video' => $videoUrl ?? null,
            'post_id' => $request['post_id'],
            'user_id' => auth()->user()->id
        ]);
        return response()->json([
            'message' => 'Comment Created Successfully',
            'status' => 200
        ]);
    }
}
