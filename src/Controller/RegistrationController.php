<?php

namespace App\Controller;

use App\Entity\User;
use App\Enum\UserRoleEnum;
use App\Form\RegistrationFormType;
use App\Security\UserAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\UserAuthenticatorInterface;

#[Route('/inscription')]
final class RegistrationController extends AbstractController
{
    #[Route(name: 'register')]
    public function __invoke(
        Request $request,
        UserPasswordHasherInterface $userPasswordHasher,
        UserAuthenticatorInterface $userAuthenticator,
        UserAuthenticator $authenticator,
        EntityManagerInterface $entityManager
    ): Response {
        $form = $this->createForm(RegistrationFormType::class, $user = new User)->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $user->setPassword($userPasswordHasher->hashPassword($user, $form->get('plainPassword')->getData()));
            $entityManager->persist($user->setRoles(array_merge($user->getRoles(), [UserRoleEnum::Member->value])));
            $entityManager->flush();

            return $userAuthenticator->authenticateUser($user, $authenticator, $request);
        }

        return $this->renderForm('registration/registration.html.twig', [
            'form' => $form,
        ]);
    }
}
