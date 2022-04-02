<?php

namespace App\Controller;

use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/projets')]
final class ProjectController extends AbstractController
{
    #[Route(name: 'projets')]
    public function __invoke(ProjectRepository $projectRepository): Response
    {
        return $this->render('app/project/archive.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }

    #[Route('/projets/{id}', name: 'project')]
    public function show(int $id, ProjectRepository $projectRepository): Response
    {
        return $this->render('app/project/show.html.twig', [
            'project' => $projectRepository->find($id),
        ]);
    }

    #[Route('/projets/ajouter', name: 'project_add')]
    public function add(): Response
    {
        return $this->render('app/project/add.html.twig');
    }

    #[Route('/projets/{id}/editer', name: 'project_edit')]
    public function edit(int $id, ProjectRepository $projectRepository): Response
    {
        return $this->render('app/project/edit.html.twig', [
            'project' => $projectRepository->find($id),
        ]);
    }

    #[Route('/projets/{id}/supprimer', name: 'project_delete')]
    public function delete(int $id, ProjectRepository $projectRepository)
    {
    }

    #[Route('/projets/exporter', name: 'projects_export')]
    public function export(ProjectRepository $projectRepository)
    {
    }
}
