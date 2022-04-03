<?php

namespace App\Controller;

use App\Entity\Fact;
use App\Entity\Project;
use App\Entity\Risk;
use App\Enum\CalendarEnum;
use App\Enum\UserRoleEnum;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class ProjectController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger
    ) {
    }

    #[Route('/projets', name: 'projects')]
    public function __invoke(ProjectRepository $projectRepository): Response
    {
        return $this->render('app/project/archive.html.twig', [
            'projects' => $projectRepository->findBy(['archived' => false], ['endedAt' => 'ASC']),
        ]);
    }

    #[Route('/projet/{uuid}', name: 'project')]
    public function show(string $uuid, ProjectRepository $projectRepository): Response
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
            'legend' => [['Risque', CalendarEnum::Risk->value], ['Fait', CalendarEnum::Fact->value]],
            'project' => $projectRepository->find($uuid)
        ]);
    }

    #[Route('/projets/nouveau', name: 'project_add')]
    public function add(Request $request): Response
    {
        $form = $this->createForm(ProjectType::class, $project = new Project)->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $this->entityManager->persist($project);
                    $this->entityManager->flush();
                    $this->addFlash('success', 'flash.form.valid');

                    return $this->redirectToRoute('project', [
                        'uuid' => $project->getUuid(),
                    ]);
                } catch (\Exception $e) {
                    $this->addFlash('danger', 'flash.form.catch.error');
                    $this->logger->critical('ProjectController - add', [
                        'exception' => $e->getMessage(),
                        'trace' => $e->getTrace(),
                    ]);
                }
            } else {
                $this->addFlash('error', 'flash.form.invalid');
            }
        }

        return $this->renderForm('app/project/add.html.twig', [
            'form' => $form,
            'project' => $project
        ]);
    }

    #[Route('/projet/{uuid}/edition', name: 'project_edit')]
    public function edit(Request $request, Project $project): Response
    {
        if ($this->isGranted(UserRoleEnum::Admin->value) || $this->getUser() === $project->getCreatedBy()) {
            $form = $this->createForm(ProjectType::class, $project)->handleRequest($request);

            if ($form->isSubmitted()) {
                if ($form->isValid()) {
                    try {
                        $this->entityManager->persist($project);
                        $this->entityManager->flush();
                        $this->addFlash('success', 'flash.form.valid');

                        return $this->redirectToRoute('project', [
                            'uuid' => $project->getUuid(),
                        ]);
                    } catch (\Exception $e) {
                        $this->addFlash('danger', 'flash.form.catch.error');
                        $this->logger->critical('ProjectController - edit', [
                            'exception' => $e->getMessage(),
                            'trace' => $e->getTrace(),
                        ]);
                    }
                } else {
                    $this->addFlash('error', 'flash.form.invalid');
                }
            }

            return $this->renderForm('app/project/edit.html.twig', [
                'form' => $form,
                'project' => $project
            ]);
        } else {
            return $this->redirectToRoute('project', [
                'uuid' => $project->getUuid(),
            ]);
        }
    }

    #[Route('/projet/{uuid}/suppression', name: 'project_delete')]
    public function delete(Project $project): RedirectResponse
    {
        if ($this->isGranted(UserRoleEnum::Admin->value) || $this->getUser() === $project->getCreatedBy()) {
            try {
                $this->entityManager->remove($project);
                $this->entityManager->flush();
                $this->addFlash('success', 'flash.form.delete.success');
            } catch (\Exception $e) {
                $this->addFlash('error', 'flash.form.delete.error');
                $this->logger->critical('ProjectController - delete', [
                    'exception' => $e->getMessage(),
                    'trace' => $e->getTrace(),
                ]);

                return $this->redirectToRoute('project', [
                    'uuid' => $project->getUuid(),
                ]);
            }

            return $this->redirectToRoute('projects', [], Response::HTTP_SEE_OTHER);
        } else {
            return $this->redirectToRoute('project', [
                'uuid' => $project->getUuid(),
            ]);
        }
    }
}
