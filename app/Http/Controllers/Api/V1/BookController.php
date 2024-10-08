<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Book\StoreRequest;
use App\Http\Requests\Book\UpdateRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use App\Policies\V1\BookPolicy;

class BookController extends ApiController
{
    protected $policyClass = BookPolicy::class;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * @OA\Get(
     *     path="/api/v1/books",
     *     tags={"Books"},
     *     summary="Cписок книг",
     *     description="Получить список книг",
     *
     *     @OA\Response(
     *         response="200",
     *         description="Cписок книг",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     ref="#/components/schemas/BookResource"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index()
    {
        $books = Book::where('user_id', auth()->id())->cursorPaginate();

        return $this->okPagination('', BookResource::collection($books));
    }

    /**
     * @OA\Post(
     *     path="/api/v1/books",
     *     tags={"Books"},
     *     summary="Создать книгу",
     *     description="Создать книгу",
     *
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/StoreBookRequest")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response="200",
     *         description="OK"
     *     )
     * )
     */
    public function store(StoreRequest $request)
    {
        $data            = $request->validated();
        $data['user_id'] = auth()->id();

        Book::create($data);

        return $this->created('Книга успешно создана!');
    }

    /**
     * @OA\Get(
     *     path="/api/v1/books/{id}",
     *     tags={"Books"},
     *     summary="Cписок книг",
     *     description="Получить список книг",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response="200",
     *         description="Cписок книг",
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="data",
     *                     ref="#/components/schemas/BookResource"
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function show(string $id)
    {
        try {
            $book = Book::findOrFail($id);

            $this->isAble('view', $book);

            return $this->ok('', new BookResource($book));
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 404);
        }
    }

    /**
     * @OA\Post(
     *     path="/api/v1/books/{id}",
     *     tags={"Books"},
     *     summary="Редактировать книгу",
     *     description="Редактировать книгу",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/UpdateBookRequest")
     *         )
     *     ),
     *
     *     @OA\Response(
     *         response="200",
     *         description="OK"
     *     )
     * )
     */
    public function update(UpdateRequest $request, string $id)
    {
        $data            = $request->validated();
        $data['user_id'] = auth()->id();

        try {
            $book = Book::query()->findOrFail($id);
            $this->isAble('update', $book);

            $book->update($data);

            return $this->ok('Книга была успешно обновлена!', null);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 404);
        }
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/books/{id}",
     *     tags={"Books"},
     *     summary="Удалить книгу",
     *     description="Удалить книгу",
     *
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *
     *     @OA\Response(
     *         response="200",
     *         description="OK"
     *     )
     * )
     */
    public function destroy(string $id)
    {
        try {
            $book = Book::findOrFail($id);

            $this->isAble('delete', $book);

            $book->deleteOrFail();

            return $this->ok('Книга была успешно удалена!', null);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 404);
        }
    }
}
