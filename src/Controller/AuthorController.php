<?php

namespace App\Controller;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api", "api_")]
class AuthorController extends AbstractController
{    
    #[Route('/author/create', methods: ['POST'])]
    public function create(Request $request, EntityManagerInterface $em): JsonResponse
    {
        $requestData = json_decode($request->getContent(), true);

        $author = new Author();
        $author->setFirstName($requestData['first_name']);
        $author->setLastName($requestData['last_name']);

        $em->persist($author);
        $em->flush();

        return new JsonResponse(['message' => 'Author created successfully'], 201);
    }

    #[Route('/author/{id}', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $em, $id): JsonResponse
    {
        $author = $em->getRepository(Author::class)->find($id);

        if ($author) {
            $em->remove($author);
            $em->flush();
    
            return new JsonResponse(['message' => 'Author deleted successfully'], 200);
        } else {
            return new JsonResponse(['error' => 'Author not found'], 404);
        }
    }
}
