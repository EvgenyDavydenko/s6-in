<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Publisher;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route("/api")]
class PublisherController extends AbstractController
{    
    #[Route('/publisher/{id}', methods: ['PATCH', 'PUT'])]
    public function edit(Request $request, EntityManagerInterface $em, $id): JsonResponse
    {
        $publisher = $em->getRepository(Publisher::class)->find($id);

        if ($publisher) {
            $data = json_decode($request->getContent(), true);
    
            if (isset($data['name'])) {
                $publisher->setName($data['name']);        }
    
            if (isset($data['address'])) {
                $publisher->setAddress($data['address']);
            }
            $em->flush();
    
            return new JsonResponse(['message' => 'Publisher updated successfully'], 200);
        } else {
            return new JsonResponse(['error' => 'Publisher not found'], 404);
        }
    }

    #[Route('/publisher/{id}', methods: ['DELETE'])]
    public function delete(EntityManagerInterface $em, $id): JsonResponse
    {
        $publisher = $em->getRepository(Publisher::class)->find($id);

        if ($publisher) {
            $em->remove($publisher);
            $em->flush();
    
            return new JsonResponse(['message' => 'Publisher deleted successfully'], 200);
        } else {
            return new JsonResponse(['error' => 'Publisher not found'], 404);
        }
    }
}
