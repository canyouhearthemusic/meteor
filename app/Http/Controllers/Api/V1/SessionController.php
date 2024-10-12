<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\BookSession\StoreRequest;
use App\Models\Book;
use App\Models\BookSession;
use App\Models\Note;
use App\Policies\V1\BookPolicy;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class SessionController extends ApiController
{
    protected $policyClass = BookPolicy::class;

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
     *     operationId="store",
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
    public function store(StoreRequest $request, Book $book): ?JsonResponse
    {
        $data = $request->validated();

        try {
            DB::transaction(static function () use ($book, $data) {
                /** @var BookSession $session */
                $session = $book->sessions()->create([
                    'session_duration' => $data['session_duration'],
                    'current_duration' => $data['current_duration'],
                ]);

                foreach ($data['notes'] as $noteData) {
                    /** @var Note $note */
                    $note = $session->notes()->create([
                        'comment' => $noteData['comment'],
                    ]);

                    if (!empty($noteData['files'])) {
                        $filesData = [];

                        foreach ($noteData['files'] as $file) {
                            $path = $file->store('note-attachments');
                            $filesData[] = [
                                'original_name' => $file->getClientOriginalName(),
                                'path'          => $path,
                                'user_id'       => auth()->id(),
                            ];
                        }

                        $note->files()->createMany($filesData);
                    }
                }
            });

            return $this->ok('OK', null);

        } catch (\Exception $e) {
            return $this->error('Ошибка при создании сесcии: ' . $e->getMessage(), 500);
        }
    }
}
