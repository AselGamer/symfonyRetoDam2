<?php

namespace App\Controller;

use App\Entity\Etiqueta;
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

class EtiquetaController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/etiqueta', name: 'app_etiqueta')]
    public function index(): Response
    {

        $etiquetas = $this->entityManager->getRepository(Etiqueta::class)->findAll();

        $parametros = [
            'etiquetas' => $etiquetas
        ];

        return $this->render('etiqueta/index.html.twig', $parametros);
    }

    #[Route('/etiqueta/add', name: 'app_etiqueta_add')]
    public function addEtiqueta(Request $request): Response
    {

        $nombre = $request->request->get('nombre');

        if ($nombre) {
            $etiqueta = new Etiqueta();
            $etiqueta->setNombre($nombre);

            $this->entityManager->persist($etiqueta);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_etiqueta');
        }

        return $this->render('etiqueta/add.html.twig', [
            'controller_name' => 'EtiquetaController',
        ]);
    }

    #[Route('/etiqueta/edit/{id}', name: 'app_etiqueta_edit')]
    public function editEtiqueta(Request $request, int $id): Response
    {

        $etiqueta = $this->entityManager->getRepository(Etiqueta::class)->find($id);

        if (!$etiqueta) {
            return $this->redirectToRoute('app_etiqueta');
        }

        $nombre = $request->request->get('nombre');

        if ($nombre) {
            $etiqueta->setNombre($nombre);

            $this->entityManager->flush();

            return $this->redirectToRoute('app_etiqueta');
        }

        $parametros['etiqueta'] = $etiqueta;

        return $this->render('etiqueta/edit.html.twig', $parametros);
    }

    #[Route('/etiqueta/delete/{id}', name: 'app_etiqueta_delete')]
    public function deleteEtiqueta(int $id): Response
    {
        $etiqueta = $this->entityManager->getRepository(Etiqueta::class)->find($id);

        if (!$etiqueta) {
            return $this->redirectToRoute('app_etiqueta');
        }

        $this->entityManager->remove($etiqueta);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_etiqueta');
    }

    #[Route('/api/etiquetas', name: 'app_etiqueta_api')]
    public function allEtiquetas(): JsonResponse
    {
        $datos = $this->entityManager->getRepository(Etiqueta::class)->findAll();

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
