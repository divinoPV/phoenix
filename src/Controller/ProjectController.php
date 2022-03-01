<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/projects')]
final class ProjectController extends AbstractController
{
    #[Route(name: 'project')]
    public function __invoke(ProjectRepository $projectRepository): Response
    {
        dd(array_reduce(['2', '3', '4'], fn ($ax, $dx) => [...$ax, $dx], ['1']));

        return $this->render('project/index.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }
}
