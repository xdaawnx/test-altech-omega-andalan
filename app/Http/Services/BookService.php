<?php 
namespace App\Http\Services;

use App\Http\Services\Interfaces\BookServiceInterface;
use App\Http\Repositories\Interfaces\BookRepositoryInterface;
use App\Http\Repositories\Interfaces\AuthorRepositoryInterface;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class BookService implements BookServiceInterface {
    protected $bookRepo;
    protected $authorRepo;

    public function __construct(
        BookRepositoryInterface $bookRepo, 
        AuthorRepositoryInterface $authorRepo
    ) {
        $this->bookRepo = $bookRepo;
        $this->authorRepo = $authorRepo;
    }

    public function getAllBooks() {
        return Cache::remember('books', 300, function () {
            // Fetch from the repository if not cached
            return $this->bookRepo->getAllBooks();
        });

    }

    public function getBookById($id) {
        $book = $this->bookRepo->getBookById($id);
        if (empty($book)) {
            throw new NotFoundHttpException("not found");
        }
        return $book;
    }

    public function createBook($data) {
        $book = $this->bookRepo->createBook($data);
        Cache::forget('books'); 
        Cache::forget("author:{$data['author_id']}");  
        return $book;
    }

    public function updateBook($id, $data) {
        try {
            
        } catch (\Throwable $th) {
            //throw $th;
        }
        $book = $this->getBookById($id);
        if (empty($book)) {
            throw new NotFoundHttpException("not found");
        }
        $updatedBook = $this->bookRepo->updateBook($id, $data);
        if ($updatedBook) {
            Cache::forget('books');  
            Cache::forget("author:{$data['author_id']}");  
        }
        return $updatedBook;
    }

    public function deleteBook($id) {
        $book = $this->getBookById($id);
        if (empty($book)) {
            throw new NotFoundHttpException("not found");
        }
        $deletedBook = $this->bookRepo->deleteBook($id);
        if ($deletedBook) {
            Cache::forget('books'); 
            Cache::forget("author:{$book->author_id}");  
        }
        return $deletedBook;
    }

    public function getBooksByAuthor($authorId) {
        $author = $this->authorRepo->getAuthorById($authorId);
        if (empty($author)) {
            throw new NotFoundHttpException("not found");
        }
        return Cache::remember("author:{$authorId}", 300, function () {
            // Fetch from the repository if not cached
            return $this->bookRepo->getAllBooks();
        });
    }
}
?>