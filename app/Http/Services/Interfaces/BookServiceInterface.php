<?php
namespace App\Http\Services\Interfaces;

interface BookServiceInterface {
    public function getAllBooks();
    public function getBookById($id);
    public function createBook($data);
    public function updateBook($id, $data);
    public function deleteBook($id);
    public function getBooksByAuthor($authorId);
}
?>