<?php

namespace App\Controller;

use App\Entity\Plataforma;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class PlataformaController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/plataforma', name: 'app_plataforma')]
    public function index(): Response
    {
        $error = false;
        $parametros['error'] = false;
        if ($error) {
            $parametros['error'] = $error;
        }

        $plataformas = $this->entityManager->getRepository(Plataforma::class)->findAll();

        $parametros['plataformas'] = $plataformas;

        return $this->render('plataforma/index.html.twig', $parametros);
    }

    #[Route('/plataformas/add', name: 'app_plataforma_add')]
    public function addPlataformas(Request $request): Response
    {

        $nombre = $request->request->get('nombre');

        if ($nombre) {
            $plataforma = new Plataforma();
            $plataforma->setNombre($nombre);

            $this->entityManager->persist($plataforma);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_plataforma');
        }

        return $this->render('plataforma/add.html.twig');
    }

    #[Route('/plataformas/edit/{id}', name: 'app_plataforma_edit')]
    public function editPlataformas(int $id, Request $request): Response
    {
        $plataforma = $this->entityManager->getRepository(Plataforma::class)->find($id);

        $nombre = $request->request->get('nombre');

        if ($nombre) {
            $plataforma->setNombre($nombre);

            $this->entityManager->flush();

            return $this->redirectToRoute('app_plataforma');
        }

        $parametros['plataforma'] = $plataforma;

        return $this->render('plataforma/edit.html.twig', $parametros);
    }

    #[Route('/plataformas/delete/{id}', name: 'app_plataforma_delete')]
    public function deletePlataformas(int $id): Response
    {
        $plataforma = $this->entityManager->getRepository(Plataforma::class)->find($id);

        if ($plataforma) {
            $this->entityManager->remove($plataforma);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_plataforma');
    }
}
