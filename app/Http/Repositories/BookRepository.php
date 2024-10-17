<?php
namespace App\Http\Repositories;

use App\Models\Book;
use App\Http\Repositories\Interfaces\BookRepositoryInterface;

class BookRepository implements BookRepositoryInterface {
    public function getAllBooks() {
        return Book::all();
    }

    public function getBookById($id) {
        return Book::find($id);
    }

    public function createBook($data) {
        return Book::create($data);
    }

    public function updateBook($id, $data) {
        $book = Book::find($id);
        $book->update($data);
        return $book;
    }

    public function deleteBook($id) {
        Book::destroy($id);
    }

    public function getBooksByAuthor($authorId) {
        return Book::where('author_id', $authorId)->get();
    }
}
?>