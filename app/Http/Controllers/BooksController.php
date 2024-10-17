<?php

namespace App\Http\Controllers;

use App\Http\Services\Interfaces\BookServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

/**
 * @OA\Tag(
 *     name="Books",
 *     description="API Endpoints for managing books"
 * )
 */
class BooksController extends Controller {
    protected $bookService;

    public function __construct(BookServiceInterface $bookService) {
        $this->bookService = $bookService;
    }

    /**
     * @OA\Get(
     *     path="/api/books",
     *     tags={"Books"},
     *     summary="Get list of all books",
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function index() {
        $books = $this->bookService->getAllBooks();
        return response()->json([
            "message" => "ok",
            "data" => $books
        ],Response::HTTP_OK);
    }

    /**
     * @OA\Get(
     *     path="/api/books/{id}",
     *     tags={"Books"},
     *     summary="Get details of a specific book",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function show($id) {
        $book = $this->bookService->getBookById($id);
        return response()->json([
            "message" => "ok",
            "data" => $book
        ],Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/books",
     *     tags={"Books"},
     *     summary="Create a new book",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Book Title"),
     *             @OA\Property(property="description", type="string", example="A brief description of the book"),
     *             @OA\Property(property="publish_date", type="string", format="date", example="2022-05-15"),
     *             @OA\Property(property="author_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Book created successfully"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function store(Request $request) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'publish_date' => 'required|date',
            'author_id' => 'required|exists:authors,id', // Ensure the author exists
        ]);

        $data = $request->only(['title', 'description', 'publish_date', 'author_id']);
        $book = $this->bookService->createBook($data);

        return response()->json([
            "message" => "created",
            "data" => $book
        ],Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/api/books/{id}",
     *     tags={"Books"},
     *     summary="Update an existing book",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Updated Book Title"),
     *             @OA\Property(property="description", type="string", example="Updated book description"),
     *             @OA\Property(property="publish_date", type="string", format="date", example="2022-06-01"),
     *             @OA\Property(property="author_id", type="integer", example=1)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Book updated successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function update(Request $request, $id) {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'publish_date' => 'required|date',
            'author_id' => 'required|exists:authors,id', // Ensure the author exists
        ]);

        $data = $request->only(['title', 'description', 'publish_date', 'author_id']);
        $book = $this->bookService->updateBook($id, $data);

        return response()->json([
            "message" => "ok",
            "data" => $book
        ],Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/api/books/{id}",
     *     tags={"Books"},
     *     summary="Delete a book",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Book deleted successfully"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Book not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function destroy($id) {
        $this->bookService->deleteBook($id);
        return response()->json(null,Response::HTTP_NO_CONTENT);
    }

    /**
     * @OA\Get(
     *     path="/api/authors/{id}/books",
     *     tags={"Books"},
     *     summary="Get list of books by a specific author",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Successful operation"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Author not found"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function getBooksByAuthor($authorId) {
        $books = $this->bookService->getBooksByAuthor($authorId);
        return response()->json([
            "message" => "ok",
            "data" => $books
        ],Response::HTTP_OK);
    }
}