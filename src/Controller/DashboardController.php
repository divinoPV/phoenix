<?php

namespace App\Controller;

use App\Enum\MemberTypeEnum;
use App\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
final class DashboardController extends AbstractController
{
    #[Route(name: 'dashboard')]
    public function __invoke(ProjectRepository $repository): Response
    {
        if (!$this->getUser()) {
            return $this->redirectToRoute('login');
        }

        return $this->render('app/dashboard/index.html.twig', [
            'myProjects' => $repository->findBy(['createdBy' => $this->getUser()], ['endedAt' => 'ASC']),
            'teamProjects' => $repository->findBy(
                [$this->getUser()->getType() === MemberTypeEnum::Customer ? 'teamCustomer' : 'teamProject' => $this->getUser()->getTeam()],
                ['endedAt' => 'ASC']
            ),
            'riskyProjects' => array_filter($repository->findBy(['archived' => false], ['endedAt' => 'ASC']), fn ($project) => 0 < $project->getRisks()->count()),
            'factProjects' => array_filter($repository->findBy(['archived' => false], ['endedAt' => 'ASC']), fn ($project) => 0 < $project->getFacts()->count())
        ]);
    }
}
