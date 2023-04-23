<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class LegalsController extends AbstractController
{
    #[Route('/mentions-legales', name: 'app_legals')]
    public function legals(): Response
    {
        return $this->render('legals/legals.html.twig', [
            'controller_name' => 'LegalsController',
        ]);
    }

    #[Route('/politique', name: 'app_policy')]
    public function policy(): Response
    {
        return $this->render('legals/policy.html.twig', [
            'controller_name' => 'LegalsController',
        ]);
    }
}
