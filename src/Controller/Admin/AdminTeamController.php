<?php

namespace App\Controller\Admin;

use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/admin/equipe')]
final class AdminTeamController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger,
        private TranslatorInterface $translator
    ) {
    }

    #[Route(name: 'admin_team')]
    public function __invoke(): Response
    {
        return $this->render('admin/team/index.html.twig');
    }

    #[Route('s', name: 'admin_team_list')]
    public function list(TeamRepository $teamRepository): Response
    {
        return $this->render('admin/team/list.html.twig', [
            'teams' => $teamRepository->findBy([], ['updatedAt' => 'DESC', 'name' => 'ASC']),
        ]);
    }

    #[Route('/nouveau', name: 'admin_team_add')]
    public function add(Request $request): Response
    {
        $form = $this->createForm(TeamType::class, $team = new Team)->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $this->entityManager->persist($team);
                    $this->entityManager->flush();
                    $this->addFlash('success', $this->translator->trans('flash.form.valid'));

                    return $this->redirectToRoute('admin_team_edit', [
                        'uuid' => $team->getUuid(),
                    ]);
                } catch (\Exception $e) {
                    $this->addFlash('danger', $this->translator->trans('flash.form.catch.error'));
                    $this->logger->critical('AdminTeamController - add', [
                        'exception' => $e->getMessage(),
                        'trace' => $e->getTrace(),
                    ]);
                }
            } else {
                $this->addFlash('error', $this->translator->trans('flash.form.invalid'));
            }
        }

        return $this->renderForm('admin/team/add.html.twig', [
            'form' => $form,
            'team' => $team
        ]);
    }

    #[Route('/{uuid}/edition', name: 'admin_team_edit')]
    public function edit(Request $request, Team $team): Response
    {
        $form = $this->createForm(TeamType::class, $team)->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $this->entityManager->persist($team);
                    $this->entityManager->flush();
                    $this->addFlash('success', $this->translator->trans('flash.form.valid'));

                    return $this->redirectToRoute('admin_team_edit', [
                        'uuid' => $team->getUuid(),
                    ]);
                } catch (\Exception $e) {
                    $this->addFlash('danger', $this->translator->trans('flash.form.catch.error'));
                    $this->logger->critical('AdminTeamController - edit', [
                        'exception' => $e->getMessage(),
                        'trace' => $e->getTrace(),
                    ]);
                }
            } else {
                $this->addFlash('error', $this->translator->trans('flash.form.invalid'));
            }
        }

        return $this->renderForm('admin/team/edit.html.twig', [
            'form' => $form,
            'team' => $team
        ]);
    }
}
