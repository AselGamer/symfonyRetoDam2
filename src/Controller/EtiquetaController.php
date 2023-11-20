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
        return $this->redirectToRoute('app_etiqueta_lista', array('offset' => 1));
    }

    #[Route('/etiqueta/pagina/', name: 'app_etiqueta_redirect')]
    public function etiquetaRedirect(): Response
    {
        return $this->redirectToRoute('app_etiqueta_lista', array('offset' => 1));
    }

    #[Route('/etiqueta/pagina/{offset}', name: 'app_etiqueta_lista')]
    public function etiquetaLista($offset): Response
    {
        if ($offset <= 0) {
            return $this->redirectToRoute('app_etiqueta_lista', array('offset' => 1));
        }

        $qdb = $this->entityManager->createQueryBuilder();

        
        $totalEtiquetas = $qdb->select('count(e.idetiqueta)')
            ->from(Etiqueta::class, 'e')
            ->getQuery()
            ->getSingleScalarResult();

        $cantPaginas = ceil($totalEtiquetas / 10);

        $qdb->select('e')
            ->setFirstResult(($offset - 1) * 10)
            ->setMaxResults(10);

        $etiquetas = $qdb->getQuery()->getResult();

        $parametros['etiquetas'] = $etiquetas;
        $parametros['paginas'] = $cantPaginas;

        return $this->render('etiqueta/index.html.twig', $parametros);
    
    }

    #[Route('/etiqueta/buscar/', name: 'app_etiqueta_buscar_redirect')]
    public function etiquetaBuscarRedirect(): Response
    {
        return $this->redirectToRoute('app_etiqueta_lista', array('offset' => 1));
    }

    #[Route('/etiqueta/buscar/{busqueda}', name: 'app_etiqueta_buscar')]
    public function etiquetaBuscar(string $busqueda): Response
    {

        $qdb = $this->entityManager->createQueryBuilder();

        $qdb->select('e')
            ->from(Etiqueta::class, 'e')
            ->where('e.nombre LIKE :busqueda')
            ->setParameter('busqueda', '%' . $busqueda . '%');

        $etiquetas = $qdb->getQuery()->getResult();

        $parametros['etiquetas'] = $etiquetas;
        $parametros['paginas'] = 1;

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
