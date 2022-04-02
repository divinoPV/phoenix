<?php

namespace App\Controller;

use App\Entity\Fact;
use App\Entity\Risk;
use App\Enum\CalendarEnum;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

final class ProjectController extends AbstractController
{
    #[Route('/projets', name: 'projects')]
    public function __invoke(ProjectRepository $projectRepository): Response
    {
        return $this->render('app/project/archive.html.twig', [
            'projects' => $projectRepository->findAll(),
        ]);
    }

    #[Route('/projet/{uuid}', name: 'project')]
    public function show(string $uuid, ProjectRepository $projectRepository, TranslatorInterface $translator): Response
    {
        $data = [];

        /** @var Risk $risk */
        foreach ($projectRepository->find($uuid)->getRisks() as $risk) {
            $data[] = [
                'id' => $risk->getUuid(),
                'start' => $risk->getIdentification()->format('Y-m-d H:i:s'),
                'end' => $risk->getResolution()->format('Y-m-d H:i:s'),
                'title' => $risk->getName(),
                'backgroundColor' => CalendarEnum::Risk->value,
            ];
        }

        /** @var Fact $fact */
        foreach ($projectRepository->find($uuid)->getFacts() as $fact) {
            $data[] = [
                'id' => $fact->getUuid(),
                'start' => $fact->getOccurred()->format('Y-m-d H:i:s'),
                'end' => $fact->getOccurred()->format('Y-m-d H:i:s'),
                'title' => $fact->getName(),
                'backgroundColor' => CalendarEnum::Fact->value,
            ];
        }

        return $this->render('app/project/show.html.twig', [
            'data' => json_encode($data),
            'project' => $projectRepository->find($uuid),
        ]);
    }

    #[Route('/projets/nouveau', name: 'project_add')]
    public function add(): Response
    {
        return $this->render('app/project/add.html.twig');
    }

    #[Route('/projets/{uuid}/edition', name: 'project_edit')]
    public function edit(string $uuid, ProjectRepository $projectRepository): Response
    {
        return $this->render('app/project/edit.html.twig', [
            'project' => $projectRepository->find($uuid),
        ]);
    }

    #[Route('/projets/{uuid}/suppression', name: 'project_delete')]
    public function delete(string $uuid, ProjectRepository $projectRepository)
    {
    }

    #[Route('/projets/exportation', name: 'projects_export')]
    public function export(ProjectRepository $projectRepository)
    {
    }
}
