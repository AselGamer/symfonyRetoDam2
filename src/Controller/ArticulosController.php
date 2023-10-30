<?php

namespace App\Controller;

use App\Entity\Marca;
use App\Entity\Articulo;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticulosController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/articulos', name: 'app_articulos')]
    public function index(): Response
    {

        $parametros['titulo'] = 'Articulos';

        $articulos = $this->entityManager->getRepository(Articulo::class)->findAll();

        $parametros['articulos'] = $articulos;

        return $this->render('articulos/index.html.twig', $parametros);
    }

    #[Route('/articulos/add', name: 'app_articulos_add', methods:['GET', 'POST'])]
    public function addArticulos(): Response
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            
        } else {
            $marcas = $this->entityManager->getRepository(Marca::class)->findAll();
            $parametros['marcas'] = $marcas;
        }
        return $this->render('articulos/add.html.twig', $parametros);
    }

    #[Route('/articulos/delete/{id}', name: 'app_articulos_delete')]
    public function delete(Int $id): Response
    {
        return $this->render('articulos/index.html.twig');
    }

    #[Route('/articulos/edit/{id}', name: 'app_articulos_edit')]
    public function edit(Int $id): Response
    {
        return $this->render('articulos/index.html.twig');
    }
}
