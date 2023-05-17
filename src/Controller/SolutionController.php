<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Solution;
use App\Entity\Developer;
use App\Entity\Problem;

class SolutionController extends AbstractController
{
    #[Route('/', name: 'app_solution')]
    public function index(): JsonResponse
    {
        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/SolutionController.php',
        ]);
    }

    /* #[Route('/solution', name: 'app_solutionList', methods: ['GET'])]
    public function solutionList(EntityManagerInterface $entityManager): JsonResponse
    {
        $solutions = $entityManager->getRepository(Solution::class)->findAll();

        $response = [];
        foreach ($solutions as $solution) {
            $response[] = [
                'id' => $solution->getId(),
                'contentS' => $solution->getContentS(),
                'dateCreation' => $solution->getDateCreation(),
                'developer' => $solution->getDeveloper()->getId(),
                'problem' => $solution->getProblem()->getId()
            ];
        }

        return $this->json($response);
    } */

    #[Route('/solution', name: 'app_solutionList', methods: ['GET'])]
public function solutionList(Request $request, EntityManagerInterface $entityManager): JsonResponse
{
    $problemId = $request->query->get('problem');
    $solutions = $entityManager->getRepository(Solution::class)->findBy(['problem' => $problemId]);

    $response = [];
    foreach ($solutions as $solution) {
        $response[] = [
            'id' => $solution->getId(),
            'contentS' => $solution->getContentS(),
            'dateCreation' => $solution->getDateCreation(),
            'developer' => $solution->getDeveloper()->getId(),
            'problem' => $solution->getProblem()->getId()
        ];
    }

    return $this->json($response);
}


    #[Route('/solution', name: 'app_solution_add', methods: ['POST'])]
    public function createSolution(Request $request, EntityManagerInterface $entityManager): Response
    {
        $solution = new Solution();
        $solution->setContentS($request->request->get('contentS'));
        $solution->setDateCreation(new \DateTime());

        $developer = $entityManager->getRepository(Developer::class)->find($request->request->get('developer'));
        $solution->setDeveloper($developer);

        $problem = $entityManager->getRepository(Problem::class)->find($request->request->get('problem'));
        $solution->setProblem($problem);

        $entityManager->persist($solution);
        $entityManager->flush();

        return $this->json('Inserted successfully!');
    }

    #[Route('/solution/{id}', name: 'app_solutionUpdate', methods: ['PUT'])]
    public function updateSolution($id, Request $request, EntityManagerInterface $entityManager): Response
    {
        $solution = $entityManager->getRepository(Solution::class)->find($id);

        $solution->setContentS($request->request->get('contentS'));
        $solution->setDateCreation(new \DateTime());

        $developer = $entityManager->getRepository(Developer::class)->find($request->request->get('developer'));
        $solution->setDeveloper($developer);

        $problem = $entityManager->getRepository(Problem::class)->find($request->request->get('problem'));
        $solution->setProblem($problem);

        $entityManager->flush();

        return $this->json('Updated successfully!');
    }

    #[Route('/solution/{id}', name: 'app_solutionDelete', methods: ['DELETE'])]
    public function deleteSolution($id, EntityManagerInterface $entityManager): JsonResponse
    {
        $solution = $entityManager->getRepository(Solution::class)->find($id);

        $entityManager->remove($solution);
        $entityManager->flush();

        return $this->json([
            'id' => $solution->getId(),
            'contentS' => $solution->getContentS(),
            'dateCreation' => $solution->getDateCreation(),
            'developer' => $solution->getDeveloper(),
            'problem' => $solution->getProblem(),
        ]);
    }
}