<?php

namespace App\Controller;

use App\Entity\Reparacion;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ReparacionController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/reparacion', name: 'app_reparacion')]
    public function index(): Response
    {
        $reparaciones = $this->entityManager->getRepository(Reparacion::class)->findAll();
        $parametros['reparaciones'] = $reparaciones;

        return $this->render('reparacion/index.html.twig', $parametros);
    }
}
