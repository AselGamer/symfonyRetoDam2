<?php

namespace App\Controller;

use App\Entity\Marca;
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

class MarcaController extends AbstractController
{

    private $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/marcas', name: 'app_marca')]
    public function index(Request $request): Response
    {

        $error = $request->getContent();
        $parametros['error'] = false;
        if ($error) {
            $parametros['error'] = $error;
        }

        $marcas = $this->entityManager->getRepository(Marca::class)->findAll();

        $parametros['marcas'] = $marcas;

        return $this->render('marca/index.html.twig', $parametros);
    }

    #[Route('/marcas/add', name: 'app_marca_add')]
    public function addMarcas(Request $request): Response
    {
        $nombre = $request->request->get('nombre');

        if ($nombre) {
            $marca = new Marca();
            $marca->setNombre($nombre);

            $this->entityManager->persist($marca);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_marca');
        }

        return $this->render('marca/add.html.twig');
    }

    #[Route('/marcas/edit/{id}', name: 'app_marca_edit')]
    public function editMarcas(int $id, Request $request): Response
    {
        $marca = $this->entityManager->getRepository(Marca::class)->find($id);

        if (!$marca) {
            return $this->redirectToRoute('app_marca');
        }

        $nombre = $request->request->get('nombre');

        if ($nombre) {
            $marca->setNombre($nombre);

            $this->entityManager->flush();

            return $this->redirectToRoute('app_marca');
        }

        $parametros['marca'] = $marca;

        return $this->render('marca/edit.html.twig', $parametros);
    }

    #[Route('/marcas/delete/{id}', name: 'app_marca_delete')]
    public function deleteMarcas(int $id): Response
    {
        $marca = $this->entityManager->getRepository(Marca::class)->find($id);

        if (!$marca) {
            return $this->redirectToRoute('app_marca');
        }

        $this->entityManager->remove($marca);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_marca');
    }

    #[Route('/api/marcas', name: 'app_marca_api')]
    public function allMarcas(): JsonResponse
    {
        $datos = $this->entityManager->getRepository(Marca::class)->findAll();

        return $this->convertToJson($datos);
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
