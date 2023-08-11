<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): PostCollection
    {
        return new PostCollection(Post::paginate()->where('user_id', $request->user()->id));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (! User::find($request->user()->id)) {
            return response()->json([
                'status' => false,
                'message' => 'user is not found',
            ], 400);
        }


        $request->validate([
            'content' => ['required', 'string'],
        ]);

        $post = Post::create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id,
        ]);

        return response()->json([
            'status' => true,
            'message' => 'post is created successfully',
            'post' => new PostResource($post),
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Request $request, $id): PostResource
    {
        return new PostResource(Post::query()->find($id));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $post = Post::find($id);

        if (! $post) {
            return response()->json([
                'status' => false,
                'message' => 'post is not found',
            ]);
        }

        $current_user_posts = Post::query()->where('user_id', $request->user()->id)->pluck('id')->toArray();

        if (! in_array($id, $current_user_posts)) {
            return response()->json([
                'status' => false,
                'message' => 'you cant edit other users posts',
            ], 400);
        }


        $validated = $request->validate([
            'content' => ['required', 'string'],
        ]);

        $post->update($validated);

        return response()->json([
            'status' => true,
            'message' => 'post is updated successfully',
            'post' => new PostResource($post),
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $post = Post::find($id);

        if (! $post) {
            return response()->json([
                'status' => false,
                'message' => 'post is not found',
            ]);
        }
        $posts = Post::query()->where('user_id', $request->user()->id)->pluck('id')->toArray();

        if (! in_array($id, $posts)) {
            return response()->json([
                'status' => false,
                'message' => 'you cant delete other users posts',
            ], 400);
        }
        $post->delete();

        return response()->json([
            'status' => true,
            'message' => 'post is deleted successfully',
        ], 200);
    }
}
