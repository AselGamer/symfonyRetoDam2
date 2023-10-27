<?php

namespace App\Controller;

use App\Entity\Usuario;
use App\Controller\AuthController;
use App\Entity\Empleado;
use Doctrine\ORM\EntityManagerInterface;
use PHPUnit\Util\Json;
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

class UsuarioController extends AbstractController
{

    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/api/usuario', name: 'app_usuario')]
    public function allUsuarios(): JsonResponse
    {
        $datos = $this->entityManager->getRepository(Usuario::class)->findAll();

        
        return $this->convertToJsonResponse($datos);
    }

    

    private function convertToJsonResponse($object):JsonResponse
    {
        $encoders = [new XmlEncoder(), new JsonEncoder()];
        $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer()];
        $serializer = new Serializer($normalizers, $encoders);
        $normalized = $serializer->normalize($object, null, array(DateTimeNormalizer::FORMAT_KEY => 'Y/m/d'));
        $jsonContent = $serializer->serialize($normalized,'json');
        return JsonResponse::fromJsonString($jsonContent,200);
    }


}
