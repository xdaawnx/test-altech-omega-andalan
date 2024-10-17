<?php
namespace App\Http\Services\Interfaces;

interface AuthorServiceInterface {
    public function getAllAuthors();
    public function getAuthorById($id);
    public function createAuthor($data);
    public function updateAuthor($id, $data);
    public function deleteAuthor($id);
}

?>