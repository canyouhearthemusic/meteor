<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\User\UpdateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProfileController extends ApiController
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
     * @OA\Post (
     *     path="/api/v1/profile/update",
     *     tags={"Profile"},
     *     summary="Обновить профиль",
     *     description="Обновить профиль",
     *
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/UpdateUserRequest")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response=200,
     *         description="OK",
     *     ),
     *
     *     security={{
     *         "bearer":{}
     *     }}
     * )
     */
    public function update(UpdateRequest $request)
    {
        try {
            DB::transaction(function () use ($request) {
                $credentials = $request->validated();

                if ($request->hasFile('avatar')) {
                    $filename = generate_filename('avatar', $request->file('avatar'));
                    $path     = $request->file('avatar')->storeAs('avatars', $filename, 'public');

                    $credentials['avatar'] = $path;
                }

                $request->user()->update($credentials);
            });
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }

        return $this->ok('Профиль успешно обновлен!', null);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
