<?php

namespace App\Controller;

use App\Entity\Plataforma;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
        return $this->redirectToRoute('app_plataforma_paginas', array('offset' => 1));
    }

    #[Route('/plataforma/paginas/', name: 'app_plataforma_redirect')]
    public function plataformaRedirect(): Response
    {
        return $this->redirectToRoute('app_plataforma_paginas', array('offset' => 1));
    }

    #[Route('/plataforma/paginas/{offset}', name: 'app_plataforma_paginas')]
    public function plataformaPaginas(int $offset): Response
    {
        
        if ($offset <= 0) {
            return $this->redirectToRoute('app_plataforma_paginas', array('offset' => 1));
        }

        $qdb = $this->entityManager->createQueryBuilder();

        $cantPlataformas = $qdb->select('count(a.idplataforma)')
            ->from('App\Entity\Plataforma', 'a')
            ->getQuery()
            ->getSingleScalarResult();

        $cantPaginas = ceil($cantPlataformas / 10);

        if ($offset > $cantPaginas) {
            return $this->redirectToRoute('app_plataforma_paginas', array('offset' => $cantPaginas));
        }


        $qdb->select('a')
            ->setFirstResult(($offset - 1) * 10)
            ->setMaxResults(10);


        $plataformas = $qdb->getQuery()->getResult();

        $parametros['plataformas'] = $plataformas;
        $parametros['paginas'] = $cantPaginas;

        return $this->render('plataforma/index.html.twig', $parametros);
    }

    #[Route('/plataforma/buscar/', name: 'app_plataforma_buscar_redirect')]
    public function plataformaBuscarRedirect(): Response
    {
        return $this->redirectToRoute('app_plataforma');
    }

    #[Route('/plataforma/buscar/{busqueda}', name: 'app_plataforma_buscar')]
    public function plataformaBuscar(string $busqueda): Response
    {
        $qdb = $this->entityManager->createQueryBuilder();

        $qdb->select('a')
            ->from('App\Entity\Plataforma', 'a')
            ->where('a.nombre LIKE :busqueda')
            ->setParameter('busqueda', '%' . $busqueda . '%');

        $plataformas = $qdb->getQuery()->getResult();

        $parametros['plataformas'] = $plataformas;
        $parametros['paginas'] = 1;

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
        $qdb = $this->entityManager->createQueryBuilder();

        $qdb->select('count(a.idplataforma)')
            ->from('App:Plataformaconsola', 'a')
            ->where('a.idplataforma = :plataforma')
            ->setParameter('plataforma', $plataforma->getIdplataforma())
            ->setMaxResults(1);
        $cantPlatConsola = $qdb->getQuery()->getSingleScalarResult();

        $qdb->select('count(v.idplataforma)')
            ->from('App:Videojuego', 'v')
            ->where('v.idplataforma = :plataforma')
            ->setParameter('plataforma', $plataforma->getIdplataforma())
            ->setMaxResults(1);
        $cantVideojuegos = $qdb->getQuery()->getSingleScalarResult();

        if ($cantVideojuegos > 0) {
            $this->addFlash('error', 'No se puede eliminar la plataforma porque tiene videojuegos asociados');
            
        }

        if ($cantPlatConsola > 0) {
            $this->addFlash('error', 'No se puede eliminar la plataforma porque tiene consolas asociadas');
        }

        if ($cantPlatConsola > 0 || $cantVideojuegos > 0) {
            return $this->redirectToRoute('app_plataforma_paginas', ['offset' => 1]);
        }

        if ($plataforma) {
            $this->entityManager->remove($plataforma);
            $this->entityManager->flush();
        }

        return $this->redirectToRoute('app_plataforma');
    }


    #[Route('/api/plataformas', name: 'app_plataforma_api')]
    public function allPlataformas(): Response
    {
        $plataformas = $this->entityManager->getRepository(Plataforma::class)->findAll();

        return $this->convertToJson($plataformas);
    }

    private function convertToJson($object): JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $normalized = $serializer->normalize($object, null, array(DateTimeNormalizer::FORMAT_KEY=>'Y/m/d'));
        $jsonContent = $serializer->serialize($normalized, 'json');
        return JsonResponse::fromJsonString($jsonContent, 200);
    }
}
