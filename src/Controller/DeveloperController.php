<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Problem;
use App\Entity\Developer;
use Symfony\Component\HttpFoundation\ResponseHeaderBag;


class DeveloperController extends AbstractController
{
    #[Route('/', name: 'app_developer')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/DeveloperController.php',
        ]);
    }

    #[Route('/developer', name: 'app_developerList', methods: ['GET'])]
    public function developerList(EntityManagerInterface $entityManager): JsonResponse
    {
        $developers = $entityManager->getRepository(Developer::class)->findAll();

        $response = [];
        foreach ($developers as $developer) {
            $response[] = [
                'id' => $developer->getId(),
                'username' => $developer->getUsername(),
                'email' => $developer->getEmail(),
            ];
        }

        $jsonResponse = $this->json($response);
        $responseHeaders = $jsonResponse->headers;
        $responseHeaders->set('Access-Control-Allow-Origin', '*');
        $responseHeaders->set('Access-Control-Allow-Methods', 'GET');
        $responseHeaders->set('Access-Control-Allow-Headers', 'Content-Type');

        return $jsonResponse;
    }
}
