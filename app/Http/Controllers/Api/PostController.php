<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;


class PostController extends Controller
{
    public function store(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'post_title' => 'required|string|max:255',
            'content' => 'required|string',
            // 'photo_path' => 'required|string',
        ]);

        // if ($validator->fails()) {
        //     return response()->json($validator->errors(), 422);
        // }
        // Simply return a JSON response
        return response()->json(['message' => 'The post was successfully created!'], 201);
    }
}

// class PostController extends Controller
// {
//     public function store(Request $request)
//     {
//         logger('This is a log message');
//         // // Validate the request data
//         // $validator = Validator::make($request->all(), [
//         //     'post_title' => 'required|string|max:255',
//         //     'content' => 'required|string',
//         //     'photo_path' => 'required|string',
//         // ]);

//         // if ($validator->fails()) {
//         //     return response()->json($validator->errors(), 422);
//         // }

//         // // Move the photo from temporary storage to the permanent location
//         // $photoPath = $request->input('photo_path');
//         // $photoName = md5(basename($photoPath) . microtime()) . '.' . pathinfo($photoPath, PATHINFO_EXTENSION);
//         // $finalPath = Storage::move($photoPath, 'public/images/' . $photoName);

//         // // Create the post in the database
//         // $post = Post::create([
//         //     'post_title' => $request->input('post_title'),
//         //     'content' => $request->input('content'),
//         //     'photo' => $photoName,
//         //     'user_id' => auth()->user()->id,
//         // ]);

//         return response()->json(['message' => 'The post was successfully created!'], 201);
//         // return response()->json(['message' => 'The post was successfully created!', 'post' => $post], 201);
//     }
// }
