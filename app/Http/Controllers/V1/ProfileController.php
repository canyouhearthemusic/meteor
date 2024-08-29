<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateRequest;
use App\Models\User;
use Illuminate\Http\Request;


class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request)
    {
        $credentials = $request->validated();

        if (isset($credentials['password'])) {
            $credentials['password'] = bcrypt($credentials['password']);
        }

        if ($request->hasFile('avatar')) {
            $filename = generate_filename('avatar', $request->file('avatar'));
            $path = $request->file('avatar')->storeAs('avatars', $filename, 'public');

            $credentials['avatar'] = $path;
        }

        try {
            $request->user()->update($credentials);
        } catch (\Exception $e) {
            return response()->json([
                "message" => "Failed to update credentials",
                "error" => $e->getMessage()
            ], 500);
        }

        return response()->json([
            "message" => "Profile updated successfully"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
