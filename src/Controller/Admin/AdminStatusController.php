<?php

namespace App\Controller\Admin;

use App\Entity\Status;
use App\Form\StatusType;
use App\Repository\StatusRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/admin/statut')]
final class AdminStatusController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger,
        private TranslatorInterface $translator
    ) {
    }

    #[Route(name: 'admin_status')]
    public function __invoke(): Response
    {
        return $this->render('admin/status/index.html.twig');
    }

    #[Route('s', name: 'admin_status_list')]
    public function list(StatusRepository $statusRepository): Response
    {
        return $this->render('admin/status/list.html.twig', [
            'status' => $statusRepository->findBy([], ['updatedAt' => 'DESC', 'name' => 'ASC']),
        ]);
    }

    #[Route('/nouveau', name: 'admin_status_add')]
    public function add(Request $request): Response
    {
        $form = $this->createForm(StatusType::class, $status = new Status)->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $this->entityManager->persist($status);
                    $this->entityManager->flush();
                    $this->addFlash('success', $this->translator->trans('flash.form.valid'));

                    return $this->redirectToRoute('admin_status_edit', [
                        'uuid' => $status->getUuid(),
                    ]);
                } catch (\Exception $e) {
                    $this->addFlash('danger', $this->translator->trans('flash.form.catch.error'));
                    $this->logger->critical('AdminStatusController - add', [
                        'exception' => $e->getMessage(),
                        'trace' => $e->getTrace(),
                    ]);
                }
            } else {
                $this->addFlash('error', $this->translator->trans('flash.form.invalid'));
            }
        }

        return $this->renderForm('admin/status/add.html.twig', [
            'form' => $form,
            'status' => $status
        ]);
    }

    #[Route('/{uuid}/edition', name: 'admin_status_edit')]
    public function edit(Request $request, Status $status): Response
    {
        $form = $this->createForm(StatusType::class, $status)->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $this->entityManager->persist($status);
                    $this->entityManager->flush();
                    $this->addFlash('success', $this->translator->trans('flash.form.valid'));

                    return $this->redirectToRoute('admin_status_edit', [
                        'uuid' => $status->getUuid(),
                    ]);
                } catch (\Exception $e) {
                    $this->addFlash('danger', $this->translator->trans('flash.form.catch.error'));
                    $this->logger->critical('AdminStatusController - edit', [
                        'exception' => $e->getMessage(),
                        'trace' => $e->getTrace(),
                    ]);
                }
            } else {
                $this->addFlash('error', $this->translator->trans('flash.form.invalid'));
            }
        }

        return $this->renderForm('admin/status/edit.html.twig', [
            'form' => $form,
            'status' => $status
        ]);
    }
}
