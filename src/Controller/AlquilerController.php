<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AlquilerController extends AbstractController
{
    #[Route('/alquiler', name: 'app_alquiler')]
    public function index(): Response
    {
        return $this->render('alquiler/index.html.twig', [
            'controller_name' => 'AlquilerController',
        ]);
    }
}
