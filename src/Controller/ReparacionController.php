<?php

namespace App\Controller;

use DateTime;
use App\Entity\Reparacion;
use App\Entity\Estadoreparacion;
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

    #[Route('/reparacion/estado/{id}', name: 'app_reparacion_estado', methods: ['GET', 'POST'])]
    public function edit(int $id): Response
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $empleado = $this->getUser();
            $reparacion = $this->entityManager->getRepository(Reparacion::class)->find($id);
            $reparacion->setIdestadoReparacion($this->entityManager->getRepository(Estadoreparacion::class)->find($_POST['estado']));
            switch ($_POST['estado']) {
                case '1':
                    $reparacion->setfechaInicio(null);
                    $reparacion->setfechaFin(null);
                    $reparacion->setComentarioReparacion(null);
                    $reparacion->setPrecio(null);
                    $reparacion->setIdempleado(null);
                    break;
                case '2':
                    empty($_POST['fecha_inicio']) ?  : $reparacion->setfechaInicio(DateTime::createFromFormat('Y-m-d', $_POST['fecha_inicio']));
                    empty($_POST['comentario_reparacion']) ?  : $reparacion->setComentarioReparacion($_POST['comentario_reparacion']);
                    $reparacion->setIdempleado($empleado);
                    break;
                case '3':
                    empty($_POST['fecha_inicio']) ?  : $reparacion->setfechaInicio(DateTime::createFromFormat('Y-m-d', $_POST['fecha_inicio']));
                    empty($_POST['fecha_fin']) ?  : $reparacion->setfechaFin(DateTime::createFromFormat('Y-m-d', $_POST['fecha_fin']));
                    empty($_POST['comentario_reparacion']) ?  : $reparacion->setComentarioReparacion($_POST['comentario_reparacion']);
                    empty($_POST['precio']) ?  : $reparacion->setPrecio($_POST['precio']);
                    $reparacion->setIdempleado($empleado);
                    break;
            }
            
            $this->entityManager->flush();
            return $this->redirectToRoute('app_reparacion');
        } else {
        $reparacion = $this->entityManager->getRepository(Reparacion::class)->findOneBy(array('idreparacion' => $id));
        $parametros['reparacion'] = $reparacion;
        $estados = $this->entityManager->getRepository(Estadoreparacion::class)->findAll();
        $parametros['estados'] = $estados;

        return $this->render('reparacion/edit.html.twig', $parametros);
        }
        
    }

    #[Route('/api/reparacion/', name: 'app_reparacion_api', methods: ['GET'])]
    public function reparacionApi(): JsonResponse
    {
        $usuario = $this->getUser();

        
        $reparaciones = $this->entityManager->getRepository(Reparacion::class)->findBy(array('idusuario' => $usuario));

        return $this->convertToJson($reparaciones);
    }

    #[Route('/api/reparacion/ver/{id}', name: 'app_reparacion_api_id', methods: ['GET'])]
    public function reparacionApiId(int $id): JsonResponse
    {
        $usuario = $this->getUser();
        $reparacion = $this->entityManager->getRepository(Reparacion::class)->findOneBy(array('idreparacion' => $id, 'idusuario' => $usuario));

        return $this->convertToJson($reparacion);
    }

    #[Route('/api/reparacion/add', name: 'app_reparacion_api_add', methods: ['POST'])]
    public function addReparacion(Request $request): JsonResponse
    {
        $datos = json_decode($request->getContent(), true);
        $usuario = $this->getUser();
        $reparacion = new Reparacion();
        $reparacion->setIdusuario($usuario);
        $reparacion->setIdestadoreparacion($this->entityManager->getRepository(Estadoreparacion::class)->findOneBy(array('idestadoreparacion' => 1)));
        $reparacion->setfechaInicio(new DateTime());
        $reparacion->setProblema($datos['problema']);
        $this->entityManager->persist($reparacion);
        $this->entityManager->flush();

        return new JsonResponse(['data' => 'Reparacion creada'], JsonResponse::HTTP_ACCEPTED);
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
