<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/admin/utilisateur')]
final class AdminUserController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private LoggerInterface $logger,
        private UserPasswordHasherInterface $userPasswordHasher
    ) {
    }

    #[Route(name: 'admin_user')]
    public function __invoke(): Response
    {
        return $this->render('admin/user/index.html.twig');
    }

    #[Route('s', name: 'admin_user_list')]
    public function list(UserRepository $userRepository): Response
    {
        return $this->render('admin/user/list.html.twig', [
            'users' => $userRepository->findAll(),
        ]);
    }

    #[Route('/nouveau', name: 'admin_user_add')]
    public function add(Request $request): Response
    {
        $form = $this->createForm(UserType::class, $user = new User, ['form_add' => true])->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $user->setPassword($this->userPasswordHasher->hashPassword($user, $form->get('plainPassword')->getData()));
                    $this->entityManager->persist($user);
                    $this->entityManager->flush();
                    $this->addFlash('success', 'flash.form.valid');

                    return $this->redirectToRoute('admin_user_edit', [
                        'id' => $user->getId(),
                    ]);
                } catch (\Exception $e) {
                    $this->addFlash('danger', 'flash.form.catch.error');
                    $this->logger->critical('UserController - add', [
                        'exception' => $e->getMessage(),
                        'trace' => $e->getTrace(),
                    ]);
                }
            } else {
                $this->addFlash('error', 'flash.form.invalid');
            }
        }

        return $this->renderForm('admin/user/add.html.twig', [
            'form' => $form,
            'user' => $user
        ]);
    }

    #[Route('/{id}/edition', name: 'admin_user_edit')]
    public function edit(Request $request, User $user): Response
    {
        $form = $this->createForm(UserType::class, $user)->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                try {
                    $user->setPassword($this->userPasswordHasher->hashPassword($user, $form->get('plainPassword')->getData()));
                    $this->entityManager->persist($user);
                    $this->entityManager->flush();
                    $this->addFlash('success', 'flash.form.valid');

                    return $this->redirectToRoute('admin_user_edit', [
                        'id' => $user->getId(),
                    ]);
                } catch (\Exception $e) {
                    $this->addFlash('danger', 'flash.form.catch.error');
                    $this->logger->critical('UserController - edit', [
                        'exception' => $e->getMessage(),
                        'trace' => $e->getTrace(),
                    ]);
                }
            } else {
                $this->addFlash('error', 'flash.form.invalid');
            }
        }

        return $this->renderForm('admin/user/edit.html.twig', [
            'form' => $form,
            'user' => $user
        ]);
    }
}
