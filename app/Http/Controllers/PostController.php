<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    public function create_post(Request $request)
{
    //validate parameters
    $data = Validator::make($request->all(), [
        'description' => 'required',
        'category_id' => 'required'
    ]);

    if ($data->fails()) {
        return response()->json([
            'message' => $data->errors(),
            'status' => 400
        ]);
    }

    
    $images = [];
    $videos = [];

    if ($request->hasFile('images')) {
        $uploadedImages = $request->file('images');
        foreach ($uploadedImages as $image) {
            $imageName = time() . '_' . $image->getClientOriginalName();
            $path = $image->storeAs('public/post/images/', $imageName);
            $imageUrl = Storage::url($path);
            $images[] = $imageUrl;
        }
    }

    if ($request->hasFile('videos')) {
        $uploadedVideos = $request->file('videos');
        foreach ($uploadedVideos as $video) {
            $videoName = time() . '_' . $video->getClientOriginalName();
            $path = $video->storeAs('public/post/videos/', $videoName);
            $videoUrl = Storage::url($path);
            $videos[] = $videoUrl;
        }
    }
    $post = Post::create([
        'description' => $request['description'],
        'image' => $images ?? null,
        'video' => $videos ?? null,
        'blogger_id' => auth()->user()->id,
        'category_id' => $request['category_id'],
    ]);

    return response()->json([
        'message' => 'Post Created Successfully',
        'status' => 200
    ]);
}

    public function my_posts() 
{
    $post = Post::query()->where('blogger_id','=',auth()->user()->id)->get();
    return response()->json([
        'posts' => $post,
        'status' => 200
    ]);
}
    public function all_posts() 
{
        $post = Post::query()->get();
        return response()->json([
            'posts' => $post,
            'status' => 200
        ]);
}

}
