<?php

namespace App\Http\Controllers;


use App\Http\Services\Interfaces\AuthorServiceInterface;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
/**
 * @OA\Tag(
 *     name="Authors",
 *     description="API Endpoints for managing authors"
 * )
 */
class AuthorsController extends Controller {
    protected $authorService;

    public function __construct(AuthorServiceInterface $authorService) {
        $this->authorService = $authorService;
    }
    /**
     * @OA\Get(
     *     path="/api/authors",
     *     tags={"Authors"},
     *     summary="Get list of authors",
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
        $authors = $this->authorService->getAllAuthors();
        return response()->json([
            "message" => "ok",
            "data" => $authors
        ],Response::HTTP_OK);
    }

     /**
     * @OA\Get(
     *     path="/api/authors/{id}",
     *     tags={"Authors"},
     *     summary="Get details of a specific author",
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
    public function show($id) {
        $author = $this->authorService->getAuthorById($id);

        return response()->json([
            "message" => "ok",
            "data" => $author
        ],Response::HTTP_OK);
    }

    /**
     * @OA\Post(
     *     path="/api/authors",
     *     tags={"Authors"},
     *     summary="Create a new author",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="Joko Parminto"),
     *             @OA\Property(property="bio", type="string", example="An amazing author"),
     *             @OA\Property(property="birth_date", type="string", format="date", example="1980-01-01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Author created successfully"
     *     ),
     *     @OA\Response(
     *         response=500,
     *         description="Internal server error"
     *     )
     * )
     */
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'bio' => 'required|string',
            'birth_date' => 'required|date', 
        ]);
        $data = $request->only(['name', 'bio', 'birth_date']);
        $author = $this->authorService->createAuthor($data);

        return response()->json([
            "message" => "created",
            "data" => $author
        ],Response::HTTP_CREATED);
    }

    /**
     * @OA\Put(
     *     path="/api/authors/{id}",
     *     tags={"Authors"},
     *     summary="Update an existing author",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string", example="John Doe"),
     *             @OA\Property(property="bio", type="string", example="An amazing author"),
     *             @OA\Property(property="birth_date", type="string", format="date", example="1980-01-01")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Author updated successfully"
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
    public function update(Request $request, $id) {
        $request->validate([
            'name' => 'required|string',
            'bio' => 'required|string',
            'birth_date' => 'required|date', 
        ]);
        $data = $request->only(['name', 'bio', 'birth_date']);
        $author = $this->authorService->updateAuthor($id, $data);

        return response()->json([
            "message" => "ok",
            "data" => $author
        ],Response::HTTP_OK);
    }

    /**
     * @OA\Delete(
     *     path="/api/authors/{id}",
     *     tags={"Authors"},
     *     summary="Delete an author",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Author deleted successfully"
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
    public function destroy($id) {
        $this->authorService->deleteAuthor($id);
        return response()->json(null,Response::HTTP_NO_CONTENT);
    }
}
