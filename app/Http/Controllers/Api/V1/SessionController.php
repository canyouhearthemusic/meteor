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
            return $this->error('Ошибка при создании сесии: ' . $e->getMessage(), 500);
        }
    }}
