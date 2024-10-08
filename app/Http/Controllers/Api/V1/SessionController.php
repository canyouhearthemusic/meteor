<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\BookSession\StoreRequest;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class SessionController extends ApiController
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Post(
     *     path="/api/v1/books/{bookId}/sessions",
     *     tags={"Book Sessions"},
     *     summary="Создать сессию книги",
     *     description="Создать сессию книги",
     *
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(ref="#/components/schemas/StoreBookSessionRequest")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response="200",
     *         description="OK",
     *     ),
     *
     *     @OA\Response(
     *         response="422",
     *         description="Unprocessable Content",
     *         @OA\JsonContent(
     *             type="object",
     *             @OA\Property(
     *                 property="message",
     *                 type="string",
     *                 example="The given data was invalid"
     *             ),
     *             @OA\Property(
     *                 property="errors",
     *                 type="object",
     *                 example={}
     *             )
     *          )
     *     ),
     *
     *     @OA\Response(
     *         response="500",
     *         description="Something went wrong"
     *      ),
     * )
     */
    public function store(StoreRequest $request, Book $book)
    {
        $data = $request->validated();

        try {
            DB::transaction(function () use ($book, $data) {
                /** @var \App\Models\BookSession $session */
                $session = $book->sessions()->create([
                    'book_id'          => $book->id,
                    'session_duration' => $data['session_duration'],
                    'current_duration' => $data['current_duration'],
                ]);

                foreach ($data['notes'] as $key => $note) {
                    $data['notes'][$key]['session_id'] = $session->id;
                }

                $session->notes()->createMany($data['notes']);
            });

            return $this->ok('OK', null);

        } catch (\Exception $e) {
            return $this->error('Ошибка при создании сесcии: ' . $e->getMessage(), 500);
        }
    }}
