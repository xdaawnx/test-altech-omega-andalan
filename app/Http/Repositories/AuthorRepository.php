<?php
namespace App\Http\Repositories;

use App\Models\Author;
use App\Http\Repositories\Interfaces\AuthorRepositoryInterface;

class AuthorRepository implements AuthorRepositoryInterface {
    public function getAllAuthors() {
        return Author::all();
    }

    public function getAuthorById($id) {
        return Author::find($id);
    }

    public function createAuthor($data) {
        return Author::create($data);
    }

    public function updateAuthor($id, $data) {
        $author = Author::find($id);
        $author->update($data);
        return $author;
    }

    public function deleteAuthor($id) {
        Author::destroy($id);
    }
}
?>