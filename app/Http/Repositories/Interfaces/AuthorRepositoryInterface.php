<?php
namespace App\Http\Repositories\Interfaces;

interface AuthorRepositoryInterface {
    public function getAllAuthors();
    public function getAuthorById($id);
    public function createAuthor($data);
    public function updateAuthor($id, $data);
    public function deleteAuthor($id);
}
?>