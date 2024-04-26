<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use App\Repository\BookRepository;
use App\Entity\Author;
use App\Entity\Book;

#[Route("/api")]
class BookController extends AbstractController
{
    #[Route('/book', methods: ['GET'])]
    public function index(BookRepository $bookRepository): JsonResponse
    {
        $books = $bookRepository->findAll();

        foreach ($books as $book) {
            $authors = [];
            foreach ($book->getAuthor() as $author) {
                $authors[] = $author->getLastName();
            }
            $publisher = '';
            if ($book->getPublisher() !== null) {
                $publisher = $book->getPublisher()->getName();
            }
            $booksInfo[] = [
                'id' => $book->getId(),
                'name' => $book->getName(),
                'year' => $book->getYear(),
                'authorsLastName' => $authors,
                'publisherName' => $publisher,
            ];
        }

        return new JsonResponse($booksInfo, 200);
    }

    #[Route('/book/create/author/{id}', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em, $id): JsonResponse
    {
        $author = $em->getRepository(Author::class)->find($id);

        if ($author) {            
            $data = json_decode($request->getContent(), true);
    
            $book = new Book();
            $book->setName($data['name']);
            $book->setYear($data['year']);
    
            $book->addAuthor($author);
    
            $em->persist($book);
            $em->flush();
    
            return new JsonResponse(['message' => 'Book created successfully'], 201);
        } else {
            return new JsonResponse(['error' => 'Author not found'], 404);
        }
    }

    #[Route('/book/{id}', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $em, $id): JsonResponse
    {
        $book = $em->getRepository(Book::class)->find($id);

        if ($book) {
            $em->remove($book);
            $em->flush();
    
            return new JsonResponse(['message' => 'Book deleted successfully'], 200);
        } else {
            return new JsonResponse(['error' => 'Book not found'], 404);
        }
    }
}
