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


class ProblemController extends AbstractController
{
    #[Route('/', name: 'app_problem_index')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/ProblemController.php',
        ]);
    }

    #[Route('/problem', name: 'app_problemList', methods: ['GET'])]
    public function problemList(EntityManagerInterface $entityManager): JsonResponse
    {
        $problems = $entityManager->getRepository(Problem::class)->findAll();

        $response = [];
        foreach ($problems as $problem) {
            $response[] = [
                'id' => $problem->getId(),
                'title' => $problem->getTitle(),
                'content' => $problem->getContent(),
                'dateCreation' => $problem->getDateCreation(),
                'developer' => $problem->getDevelopeur()->getId(),
            ];
        }

        $jsonResponse = $this->json($response);
       return $this->json($response);
    }


 /* #[Route('/problem', name: 'app_problem_add', methods: ['POST'])]
    public function createProblem(Request $request, EntityManagerInterface $entityManager): Response
    {
        $problem = new Problem();
        $problem->setTitle($request->request->get('title'));
        $problem->setContent($request->request->get('content'));
        $problem->setDateCreation(new \DateTime());

        $developer = $entityManager->getRepository(Developer::class)->find($request->request->get('developer'));
        $problem->setDevelopeur($developer);

        $entityManager->persist($problem);
        $entityManager->flush();

        return $this->json('Insere avec succes ! ');
    }
  */

  #[Route('/problem', name: 'app_problem_add', methods: ['POST'])]
public function createProblem(Request $request, EntityManagerInterface $entityManager): Response
{
    $problem = new Problem();
    
    $title = $request->request->get('title');
    $content = $request->request->get('content');
    $developerId = $request->request->get('developer');
    
    // Debugging statements
    echo "Received title: " . $title . "\n";
    echo "Received content: " . $content . "\n";
    echo "Received developer ID: " . $developerId . "\n";

    $problem->setTitle($title);
    $problem->setContent($content);
    $problem->setDateCreation(new \DateTime());

    $developer = $entityManager->getRepository(Developer::class)->find($developerId);
    $problem->setDevelopeur($developer);

    $entityManager->persist($problem);
    $entityManager->flush();

    return $this->json('Insere avec succes ! ');
}


    #[Route('/problem/{id}', name: 'app_problemUpdate', methods: ['PUT'])]
public function updateProblem($id, Request $request, EntityManagerInterface $entityManager): Response
{
    $problem = $entityManager->getRepository(Problem::class)->find($id);

    $problem->setTitle($request->request->get('title'));
    $problem->setContent($request->request->get('content'));
    $problem->setDateCreation(new \DateTime());

    $developer = $entityManager->getRepository(Developer::class)->find($request->request->get('developer'));
    $problem->setDevelopeur($developer);

    $entityManager->flush();

    return $this->json('Modifié avec succès ! ');
}


    #[Route('/problem/{id}', name: 'app_problemDelete', methods: ['DELETE'])]
    public function deleteProblem($id, EntityManagerInterface $entityManager): JsonResponse
    {
        $problem = $entityManager->getRepository(Problem::class)->find($id);

        $entityManager->remove($problem);
        $entityManager->flush();

        return $this->json([
            'id' => $problem->getId(),
            'title' => $problem->getTitle(),
            'content' => $problem->getContent(),
            'dateCreation' => $problem->getDateCreation(),
            'developer' => $problem->getDevelopeur(),
        ]);
    }


}
