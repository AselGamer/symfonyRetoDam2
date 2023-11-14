<?php

namespace App\Controller;

use App\Entity\Compra;
use PHPUnit\Util\Json;
use App\Entity\Alquiler;
use App\Entity\Articulo;
use App\Entity\Transaccion;
use App\Entity\VistaTransaccion;
use Doctrine\ORM\Mapping\Entity;
use App\Entity\Detalletransaccion;
use DateTime;
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

    #[Route('/api/transaccion/{tipo}', name: 'app_transacciones_api_usuario', methods:['GET'])]
    public function getTransaccion(string $tipo): JsonResponse
    {
        $transacciones = $this->entityManager->getRepository(VistaTransaccion::class)->findBy(['idusuario'=>$this->getUser(), 'tipotransaccion'=>$tipo]);

        $datos['transacciones'] = array();

        $loop = 0;

        if ($tipo == 'Compra') {
            foreach ($transacciones as $transaccion) {
                $compra = $this->entityManager->getRepository(Compra::class)->findOneBy(['idtransaccion'=>$transaccion->getIdtransaccion()]);
                $detallesTransaccion = $this->entityManager->getRepository(Detalletransaccion::class)->findBy(['idtransaccion'=>$transaccion->getIdtransaccion()]);
                array_push($datos['transacciones'], [
                    'idtransaccion' => $transaccion->getIdtransaccion(),
                    'latitud' => $transaccion->getLatitud(),
                    'longitud' => $transaccion->getLongitud(),
                    'fecha' => $compra->getFecha()->format('Y-m-d'),
                    'detalles' => [],
                ]);
                foreach ($detallesTransaccion as $detalle)
                {
                    array_push($datos['transacciones'][$loop]['detalles'], [
                        'iddetalletransaccion' => $detalle->getIddetalletransaccion(),
                        'idproducto' => $detalle->getIdarticulo(),
                        'precio_total' => $detalle->getPrecioTotal(),
                    ]);
                }
                $loop += 1;
            }
        } elseif ($tipo == 'Alquiler') {
            foreach ($transacciones as $transaccion) {
                $alquiler = $this->entityManager->getRepository(Alquiler::class)->findOneBy(['idtransaccion'=>$transaccion->getIdtransaccion()]);
                $detallesTransaccion = $this->entityManager->getRepository(Detalletransaccion::class)->findBy(['idtransaccion'=>$transaccion->getIdtransaccion()]);
                array_push($datos['transacciones'], [
                    'idtransaccion' => $transaccion->getIdtransaccion(),
                    'latitud' => $transaccion->getLatitud(),
                    'longitud' => $transaccion->getLongitud(),
                    'fecha_inicio' => $alquiler->getFechaInicio()->format('Y-m-d'),
                    'fecha_fin' => $alquiler->getFechaFin()->format('Y-m-d'),
                    'fecha_devolucion' => $alquiler->getFechaDevolucion()->format('Y-m-d'),
                    'precio' => $alquiler->getPrecio(),
                    'detalles' => [],
                ]);
                foreach ($detallesTransaccion as $detalle)
                {
                    array_push($datos['transacciones'][$loop]['detalles'], [
                        'iddetalletransaccion' => $detalle->getIddetalletransaccion(),
                        'idproducto' => $detalle->getIdarticulo(),
                        'precio_total' => $detalle->getPrecioTotal(),
                    ]);
                }
                $loop += 1;
            }
        } else
        {
            return new JsonResponse(['data' => 'Tipo de transacción no válido'], JsonResponse::HTTP_BAD_REQUEST);
        }

        return $this->convertToJson($datos);
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
        } elseif ($transaccion->getTipotransaccion() == 'Alquiler') {
            $alquiler = $this->entityManager->getRepository(Alquiler::class)->findOneBy(['idtransaccion'=>$id]);
            $datos['alquiler'] = [
                'idalquiler' => $alquiler->getIdalquiler(),
                'fecha_inicio' => $alquiler->getFechaInicio()->format('Y-m-d'),
                'fecha_fin' => $alquiler->getFechaFin()->format('Y-m-d'),
                'fecha_devolucion' => $alquiler->getFechaDevolucion()->format('Y-m-d'),
                'precio' => $alquiler->getPrecio(),
            ];
        }

        $detallesTransaccion = $this->entityManager->getRepository(Detalletransaccion::class)->findBy(['idtransaccion'=>$id]);

        $datos['transaccion'] = [
            'idtransaccion' => $transaccion->getIdtransaccion(),
            'latitud' => $transaccion->getLatitud(),
            'longitud' => $transaccion->getLongitud(),
            'idusuario' => $transaccion->getIdusuario()->getIdusuario(),
        ];
        $datos['detalles'] = array();
        $loops = 0;
        foreach ($detallesTransaccion as $detalle) {

            array_push($datos['detalles'], [
                'iddetalletransaccion' => $detalle->getIddetalletransaccion(),
                'idproducto' => $detalle->getIdarticulo(),
                'precio_total' => $detalle->getPrecioTotal(),
            ]);
            $loops += 1;
        }

        return $this->convertToJson($datos);
    }


    #[Route('/api/transaccion/add', name: 'app_transacciones_api_add', methods:['POST'])]
    public function addCompra(Request $request): JsonResponse
    {
        $usuario = $this->getUser();
        $datos = json_decode($request->getContent(), true);

        if (empty($datos['latitud']) || empty($datos['longitud']) || empty($datos['detalles'] || empty($datos['tipo_transaccion']))) {
            return new JsonResponse(['data' => 'Faltan datos'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $transaccion = new Transaccion();
        $transaccion->setIdusuario($usuario);
        $transaccion->setLatitud($datos['latitud']);
        $transaccion->setLongitud($datos['longitud']);
        $this->entityManager->persist($transaccion);

        if ($datos['tipo_transaccion'] == 'Compra') {
            $compra = new Compra();
            $compra->setFecha(new \DateTime('now'));
            $compra->setIdtransaccion($transaccion);
            $this->entityManager->persist($compra);
        } else if ($datos["tipo_transaccion"] == 'Alquiler')
        {
            $alquiler = new Alquiler();
            $alquiler->setFechaInicio(DateTime::createFromFormat('Y-m-d', $datos['fecha_inicio']));
            $alquiler->setFechaFin(DateTime::createFromFormat('Y-m-d', $datos['fecha_fin']));
            $alquiler->setFechaDevolucion(DateTime::createFromFormat('Y-m-d', $datos['fecha_devolucion']));
            $alquiler->setPrecio($datos['precio']);
            $alquiler->setIdtransaccion($transaccion);
            $this->entityManager->persist($alquiler);
        } else {
            return new JsonResponse(['data' => 'Tipo de transacción no válido'], JsonResponse::HTTP_BAD_REQUEST);
        }

        
        foreach ($datos['detalles'] as $detalle) {
            $detalleTransaccion = new Detalletransaccion();
            $detalleTransaccion->setIdtransaccion($transaccion);
            $articulo = $this->entityManager->getRepository(Articulo::class)->findOneBy(array('idarticulo'=>$detalle['idproducto']));
            if ($articulo->getStock() < 1 && $datos['tipo_transaccion'] == 'Compra') {
                return new JsonResponse(['data' => 'No hay stock suficiente'], JsonResponse::HTTP_BAD_REQUEST);
            } else if($datos['tipo_transaccion'] == 'Compra' && $articulo->getStock() >= 1)
            {
                $articulo->setStock($articulo->getStock() - 1);
            }

            if ($articulo->getStockAlquiler() < 1 && $datos['tipo_transaccion'] == 'Alquiler') {
                return new JsonResponse(['data' => 'No hay stock suficiente para alquilar'], JsonResponse::HTTP_BAD_REQUEST);
            } else if($datos['tipo_transaccion'] == 'Alquiler' && $articulo->getStockAlquiler() >= 1)
            {
                $articulo->setStockAlquiler($articulo->getStockAlquiler() - 1);
            }
            $detalleTransaccion->setIdarticulo($articulo);
            $detalleTransaccion->setPrecioTotal($detalle['precio_total']);
            $this->entityManager->persist($detalleTransaccion);
        }

        $this->entityManager->flush();
        return new JsonResponse(['data' => 'Transaccion creada'], JsonResponse::HTTP_CREATED);
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
