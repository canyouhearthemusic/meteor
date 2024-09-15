<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Book\StoreRequest;
use App\Http\Requests\Book\UpdateRequest;
use App\Models\Book;
use App\Policies\V1\BookPolicy;
use Illuminate\Http\Request;

class BookController extends ApiController
{
    protected $policyClass = BookPolicy::class;

    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $books = Book::where('user_id', auth()->id())->cursorPaginate();

        return $this->okPagination('', $books);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        Book::create($data);

        $this->created('Книга успешно создана!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $book = Book::findOrFail($id);

            $this->isAble('view', $book);

            return $this->ok('', $book);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRequest $request, string $id)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        try {
            $book = Book::findOrFail($id);

            $this->isAble('update', $book);

            $book->update($data);

            return $this->ok('Книга была успешно обновлена!', null);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $book = Book::findOrFail($id);

            $this->isAble('delete', $book);

            $book->deleteOrFail();

            return $this->ok('Книга была успшено удалена!', null);
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 404);
        }
    }
}
