<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResourece;
use App\Http\Resources\UserCollection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new UserCollection(User::paginate());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => ['required', 'unique:users', 'ascii'],
            'email' => ['required', 'email', 'unique:users'],
            'password' => ['required', Rules\Password::default()],

        ]);

        $validated['password'] = Hash::make($validated['password']);

        return response()->json(new UserResourece(User::query()->create($validated)), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = User::query()->find($id);
        if (! $user) {
            return response()->json([
                'status' => false,
                'message' => 'user is not found',
            ], 400);
        }
        return new UserResourece($user);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::find($id);

        if (! $user) {
            return response()->json([
                'status' => false,
                'message' => 'user is not found',
            ], 400);
        }

        if ($id !== $request->user()->id) {
            return response()->json([
                'status' => false,
                'message' => 'you cant change other users data',
            ], 400);
        }

        $validated = $request->validate([
            'username' => ['sometimes', 'unique:users,username,' . $user->id, 'alpha_num'],
            'email' => ['sometimes', 'email', 'unique:users,email,' . $user->id],
            'password' => ['sometimes', Rules\Password::default()],
        ]);

        if ($request->has('password')) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);
        return response()->json(new UserResourece($user), 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, string $id)
    {
        $user = User::query()->findOrFail($id);
        $request->user()->CurrentAccessToken()->delete();
        $user->delete();
        return response()->json([
            'status' => true,
            'message' => 'user is deleted successfully',
        ], 200);
    }


}
