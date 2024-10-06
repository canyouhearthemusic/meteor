<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\User\LoginRequest;
use App\Http\Requests\User\RegisterRequest;
use App\Models\User;

class AuthController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api', [
            'except' => ['login', 'register', 'refresh']
        ]);
    }

    /**
     * @OA\Post (
     *    path="/api/v1/auth/login",
     *    tags={"Authentication"},
     *    summary="Логин",
     *    description="Логин",
     *
     *    @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/LoginUserRequest")
     *         )
     *     ),
     *    @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMjA3LjE1NC4yMTYuMTQvYXBpL3YxL2F1dGgvcmVnaXN0ZXIiLCJpYXQiOjE3MjgxNjA2ODIsImV4cCI6MTcyODE2NjY4MiwibmJmIjoxNzI4MTYwNjgyLCJqdGkiOiJFeXJKb05yNXhFdWZpaVV5Iiwic3ViIjoiOSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.NkCVbpCtawv5lAjXmVLcRdwzYgpmhJ1FbhV1acSRKEE"),
     *              @OA\Property(property="expires_in", type="integer", example="6000"),
     *          )
     *     ),
     *    security={{
     *     "bearer":{}
     *   }}
     * )
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (!$token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    /**
     * @OA\Post (
     *    path="/api/v1/auth/register",
     *    tags={"Authentication"},
     *    summary="Регистрация",
     *    description="Регистрация",
     *
     *    @OA\RequestBody(
     *          @OA\MediaType(
     *              mediaType="application/json",
     *              @OA\Schema(ref="#/components/schemas/RegisterUserRequest")
     *         )
     *     ),
     *    @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMjA3LjE1NC4yMTYuMTQvYXBpL3YxL2F1dGgvcmVnaXN0ZXIiLCJpYXQiOjE3MjgxNjA2ODIsImV4cCI6MTcyODE2NjY4MiwibmJmIjoxNzI4MTYwNjgyLCJqdGkiOiJFeXJKb05yNXhFdWZpaVV5Iiwic3ViIjoiOSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.NkCVbpCtawv5lAjXmVLcRdwzYgpmhJ1FbhV1acSRKEE"),
     *              @OA\Property(property="expires_in", type="integer", example="6000"),
     *          )
     *     ),
     *    security={{
     *     "bearer":{}
     *   }}
     * )
     */
    public function register(RegisterRequest $request)
    {
        $credentials = $request->validated();

        $user = User::create($credentials);

        $token = auth()->login($user);

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return auth()->user();
    }

    /**
     * @OA\Post (
     *    path="/api/v1/auth/logout",
     *    tags={"Authentication"},
     *    summary="Выйти",
     *    description="Выйти",
     *
     *    @OA\Response(
     *        response=200,
     *        description="OK",
     *     ),
     *    security={{
     *     "bearer":{}
     *   }}
     * )
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * @OA\Post (
     *    path="/api/v1/auth/refresh",
     *    tags={"Authentication"},
     *    summary="Рефреш",
     *    description="Рефреш",
     *
     *    @OA\Response(
     *          response=200,
     *          description="OK",
     *          @OA\JsonContent(
     *              @OA\Property(property="access_token", type="string", example="eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOi8vMjA3LjE1NC4yMTYuMTQvYXBpL3YxL2F1dGgvcmVnaXN0ZXIiLCJpYXQiOjE3MjgxNjA2ODIsImV4cCI6MTcyODE2NjY4MiwibmJmIjoxNzI4MTYwNjgyLCJqdGkiOiJFeXJKb05yNXhFdWZpaVV5Iiwic3ViIjoiOSIsInBydiI6IjIzYmQ1Yzg5NDlmNjAwYWRiMzllNzAxYzQwMDg3MmRiN2E1OTc2ZjcifQ.NkCVbpCtawv5lAjXmVLcRdwzYgpmhJ1FbhV1acSRKEE"),
     *              @OA\Property(property="expires_in", type="integer", example="6000"),
     *          )
     *     ),
     *    security={{
     *     "bearer":{}
     *   }}
     * )
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'expires_in'   => config('jwt.ttl') * 60,
        ]);
    }
}
