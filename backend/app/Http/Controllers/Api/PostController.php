<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        try {
            $data = Post::orderBy('id', 'desc')->get();
            return response()->json([
                'status' => true,
                'data' => $data,
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage()
            ]);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:191',
            'price' => 'required|max:8',
            'image' => 'required|image',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json(['status' => false, 'errors'=> $validator->messages()]);
        }

        try {
            if ($request->hasFile('image')) {
                $file = $request->file('image');
                $name = time() . '_Post_' . $file->getClientOriginalName();
                $file->move('image/', $name);
                $image = $name;
            }

            Post::create([
                'title'       => $request->title,
                'price'       => $request->price,
                'description' => $request->description,
                'image'       => $image
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Post added successfully.',
            ]);
        } catch (\Exception $exception) {
            return response()->json([
                'status' => true,
                'message' => 'Post added successfully.',
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        try {
            $post = Post::find($id);
            if (!empty($post)) {
                return response()->json([
                    'status' => true,
                    'data' => $post,
                    'message' => 'Post update successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Something went wrong. This Post can not delete please try again.',
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $rules = [
            'title' => 'required|max:191',
            'price' => 'required|max:8',
        ];

        $validator = Validator::make($request->all(), $rules);
        if($validator->fails()) {
            return response()->json(['status' => false, 'errors'=> $validator->messages()]);
        }

        try {
            $post = Post::find($id);
            if ($request->hasFile('image')) {
                if ($post->image){
                    unlink(public_path('/image/').$post->image);
                }
                $file = $request->file('image');
                $name = time() . '_Post_' . $file->getClientOriginalName();
                $file->move('image/', $name);
                $image = $name;
            }

            if (!empty($post)) {
                $post->update([
                    'title'       => $request->title,
                    'price'       => $request->price,
                    'description' => $request->description,
                    'image'       => isset($image) ? $image : $post->image,
                    'updated_at'  => now()
                ]);

                return response()->json([
                    'status' => true,
                    'message' => 'Post update successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Something went wrong. This Post can not updated please try again.',
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        try {
            $post = Post::find($id);
            if (!empty($post)) {
                if ($post->image){
                    unlink(public_path('/image/').$post->image);
                }
                $post->delete();
                return response()->json([
                    'status' => true,
                    'message' => 'Post update successfully.',
                ]);
            } else {
                return response()->json([
                    'status' => false,
                    'message' => 'Something went wrong. This Post can not delete please try again.',
                ]);
            }
        } catch (\Exception $exception) {
            return response()->json([
                'status' => false,
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
