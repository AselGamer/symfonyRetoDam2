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

    #[Route('/marcas/pagina/{offset}', name: 'app_marca')]
    public function index(int $offset, Request $request): Response
    {
        if ($offset < 1) {
            return $this->redirectToRoute('app_marca', ['offset' => 1]);
        }

        $totalMarcas = $this->entityManager->getRepository(Marca::class)->countMarcas();
        
        if ($totalMarcas == 0) {
            return $this->redirectToRoute('app_marca_add');
        }

        $cantPaginas = ceil($totalMarcas / 10);

        $parametros['paginas'] = $cantPaginas;

        if ($offset > $parametros['paginas']) {
            return $this->redirectToRoute('app_marca', ['offset' => $cantPaginas]);
        }

        $marcas = $this->entityManager->getRepository(Marca::class)->findAllOffsetWithMax($offset - 1);

        $parametros['marcas'] = $marcas;

        return $this->render('marca/index.html.twig', $parametros);
    }

    #[Route('/marcas', name: 'app_marca_redirect')]
    public function redirectToIndex(): Response
    {
        return $this->redirectToRoute('app_marca', ['offset' => 1]);
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

            return $this->redirectToRoute('app_marca', ['offset' => 1]);
        }

        return $this->render('marca/add.html.twig');
    }

    #[Route('/marcas/edit/{id}', name: 'app_marca_edit', methods: ['GET', 'POST'])]
    public function editMarcas(int $id, Request $request): Response
    {
        $marca = $this->entityManager->getRepository(Marca::class)->find($id);

        if (!$marca) {
            return $this->redirectToRoute('app_marca', ['offset' => 1]);
        }

        $nombre = $request->request->get('nombre');

        if ($nombre) {
            $marca->setNombre($nombre);

            $this->entityManager->flush();

            return $this->redirectToRoute('app_marca', ['offset' => 1]);
        }

        $parametros['marca'] = $marca;

        return $this->render('marca/edit.html.twig', $parametros);
    }

    #[Route('/marcas/delete/{id}', name: 'app_marca_delete')]
    public function deleteMarcas(int $id): Response
    {
        $marca = $this->entityManager->getRepository(Marca::class)->find($id);

        if (!$marca) {
            return $this->redirectToRoute('app_marca', ['offset' => 1]);
        }

        $this->entityManager->remove($marca);
        $this->entityManager->flush();

        return $this->redirectToRoute('app_marca', ['offset' => 1]);
    }

    #[Route('/api/marcas', name: 'app_marca_api')]
    public function allMarcas(): JsonResponse
    {
        $datos = $this->entityManager->getRepository(Marca::class)->findAll();

        return $this->convertToJson($datos);
    }

    #[Route('/api/marcas/{tipo}', name: 'app_marca_api_tipo')]
    public function allMarcasOfArticuloType(string $tipo): JsonResponse
    {
        $datos = $this->entityManager->getRepository(Marca::class)->findMarcaOfArticuloType($tipo);

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
