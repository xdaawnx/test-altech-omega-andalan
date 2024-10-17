<?php
namespace App\Http\Services;

use App\Http\Repositories\Interfaces\AuthorRepositoryInterface;
use App\Http\Services\Interfaces\AuthorServiceInterface;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthorService implements AuthorServiceInterface {
    protected $authorRepository;

    public function __construct(AuthorRepositoryInterface $authorRepository) {
        $this->authorRepository = $authorRepository;
    }

    public function getAllAuthors() {
        return Cache::remember('authors', 300, function () {
            // Fetch from the repository if not cached
            return $this->authorRepository->getAllAuthors();
        });
    }

    public function getAuthorById($id) {
        $author = $this->authorRepository->getAuthorById($id);
        if (empty($author)) {
            throw new NotFoundHttpException("not found");
        }
        return $author;
    }

    public function createAuthor($data) {
        $author = $this->authorRepository->createAuthor($data);
        if ($author) {
            Cache::forget('authors');  
        }
        return $author;
    }

    public function updateAuthor($id, $data) {
        $author = $this->getAuthorById($id);
        if (empty($author)) {
            throw new NotFoundHttpException("not found");
        }

        $updatedAuthor = $this->authorRepository->updateAuthor($id, $data);
        if ($updatedAuthor) {
            Cache::forget('authors');  
        }

        return $updatedAuthor;
    }

    public function deleteAuthor($id) {
        $author = $this->getAuthorById($id);
        if (empty($author)) {
            throw new NotFoundHttpException("not found");
        }

        $deletedAuthor = $this->authorRepository->deleteAuthor($id);
        if ($deletedAuthor) {
            Cache::forget('authors'); 
            Cache::forget("author:{$id}");  
        }
        return $deletedAuthor;
    }
}
?>