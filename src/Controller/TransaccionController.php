<?php

namespace App\Controller;

use App\Entity\Compra;
use App\Entity\Detalletransaccion;
use App\Entity\Transaccion;
use App\Entity\VistaTransaccion;
use PHPUnit\Util\Json;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Serializer\Serializer;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Serializer\Encoder\XmlEncoder;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class TransaccionController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }


    #[Route('/compra', name: 'app_compras')]
    public function index(): Response
    {
        return $this->render('compras/index.html.twig', [
            'controller_name' => 'ComprasController',
        ]);
    }


    #[Route('/api/compra/add', name: 'app_compra_add')]
    public function addCompra(): JsonResponse
    {
        return new JsonResponse(['data' => 'Compra añadida'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/api/transaccion/', name: 'app_transacciones_api_usuario', methods:['GET'])]
    public function getTransaccion(): JsonResponse
    {
        $transacciones = $this->entityManager->getRepository(VistaTransaccion::class)->findBy(['idusuario'=>$this->getUser()]);

        return $this->convertToJson($transacciones);
    }

    #[Route('/api/transaccion/{id}', name: 'app_transacciones_api_id', methods:['GET'])]
    public function viewTransaccion($id): JsonResponse
    {
        $usuario = $this->getUser();

        $transaccion = $this->entityManager->getRepository(VistaTransaccion::class)->findOneBy(['idtransaccion'=>$id]);

        if ($usuario != $transaccion->getIdusuario()) {
            return new JsonResponse(['data' => 'No tienes permisos para ver esta transacción'], JsonResponse::HTTP_UNAUTHORIZED);
        }

        if ($transaccion->getTipotransaccion() == 'Compra') {
            $compra = $this->entityManager->getRepository(Compra::class)->findOneBy(['idtransaccion'=>$id]);
            $datos['compra'] = [
                'idcompra' => $compra->getIdcompra(),
                'fecha' => $compra->getFecha()->format('Y-m-d'),
            ];
        }

        $detallesTransaccion = $this->entityManager->getRepository(Detalletransaccion::class)->findBy(['idtransaccion'=>$id]);

        $datos['transaccion'] = [
            'idtransaccion' => $transaccion->getIdtransaccion(),
            'latitud' => $transaccion->getLatitud(),
            'longitud' => $transaccion->getLongitud(),
            'idusuario' => $transaccion->getIdusuario()->getIdusuario(),
        ];
        $datos['detalles'] = [];
        foreach ($detallesTransaccion as $detalle) {
            $datos['detalles'] += 
            [
                'iddetalletransaccion' => $detalle->getIddetalletransaccion(),
                'idproducto' => $detalle->getIdarticulo(),
                'precio_total' => $detalle->getPrecioTotal(),
            ];
        }

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
