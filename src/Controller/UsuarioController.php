<?php

namespace App\Controller;

use PHPUnit\Util\Json;
use App\Entity\Usuario;
use App\Entity\Empleado;
use App\Controller\AuthController;
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
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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

    #[Route('/api/register', name: 'app_usuario_register', methods:['POST'])]
    public function registerUsuario(Request $request, UserPasswordHasherInterface $passwordHasher): JsonResponse
    {
        $usaurioExist = $this->entityManager->getRepository(Usuario::class)->findOneBy(['email'=>$request->get('email')]);
        if (!$usaurioExist) {
            $data = json_decode($request->getContent(),true);
            if (empty($data['nombre']) || empty($data['password']) || empty($data['email'])) {
                return new JsonResponse(['data' => 'Faltan datos'], JsonResponse::HTTP_BAD_REQUEST);
            }
            $usuario = new Usuario();
            empty($data['nombre']) ? true : $usuario->setNombre($data['nombre']);
            empty($data['apellido1']) ? true : $usuario->setApellido1($data['apellido1']);
            empty($data['apellido2']) ? true : $usuario->setApellido2($data['apellido2']);
            empty($data['email']) ? true : $usuario->setEmail($data['email']);
            empty($data['password']) ? true : $usuario->setPassword($passwordHasher->hashPassword($usuario, $data['password']));
            empty($data['telefono']) ? true : $usuario->setTelefono($data['telefono']);
            empty($data['calle']) ? true : $usuario->setCalle($data['calle']);
            empty($data['numPortal']) ? true : $usuario->setNumPortal($data['numPortal']);
            empty($data['piso']) ? true : $usuario->setPiso($data['piso']);
            empty($data['codigoPostal']) ? true : $usuario->setCodigoPostal($data['codigoPostal']);
            empty($data['ciudad']) ? true : $usuario->setCiudad($data['ciudad']);
            empty($data['pais']) ? true : $usuario->setPais($data['pais']);
            empty($data['provincia']) ? true : $usuario->setProvincia($data['provincia']);
            $this->entityManager->persist($usuario);
            $this->entityManager->flush();

            return new JsonResponse(['data' => 'Usuario Creado'], JsonResponse::HTTP_CREATED);
        } else {
            return new JsonResponse(['data' => 'Usuario ya existe'], JsonResponse::HTTP_CONFLICT);
        }
    }


    #[Route('/', name: 'app_usuario')]
    public function redirectToLogin(): Response
    {
        return $this->redirect('/login',301);
    }


    #[Route('/api/usuario/data', name: 'app_usuario_datos')]
    public function myUsuario(): JsonResponse
    {
        /** @var Usuario $usuario */
        $usuario = $this->getUser();

        $datos['idusuario'] = $usuario->getIdusuario();
        $datos['nombre'] = $usuario->getNombre();
        $datos['apellido1'] = $usuario->getApellido1();
        $datos['apellido2'] = $usuario->getApellido2();
        $datos['email'] = $usuario->getEmail();
        $datos['telefono'] = $usuario->getTelefono();
        $datos['calle'] = $usuario->getCalle();
        $datos['numPortal'] = $usuario->getNumPortal();
        $datos['piso'] = $usuario->getPiso();
        $datos['codigoPostal'] = $usuario->getCodigoPostal();
        $datos['ciudad'] = $usuario->getCiudad();
        $datos['pais'] = $usuario->getPais();
        $datos['provincia'] = $usuario->getProvincia();

        
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
