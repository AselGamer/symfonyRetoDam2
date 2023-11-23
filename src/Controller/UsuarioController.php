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
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Lexik\Bundle\JWTAuthenticationBundle\Encoder\JWTEncoderInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Exception\JWTDecodeFailureException;

class UsuarioController extends AbstractController
{

    private EntityManagerInterface $entityManager;
    private JWTEncoderInterface $JWTEncoderInterface;

    public function __construct(EntityManagerInterface $entityManager, JWTEncoderInterface $JWTEncoderInterface)
    {
        $this->entityManager = $entityManager;
        $this->JWTEncoderInterface = $JWTEncoderInterface;
    }

    #[Route('/api/usuario', name: 'app_usuario', methods:['GET'])]
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

    #[Route('/api/usuario/actualizar', name: 'app_usuario_actualizar', methods:['PUT'])]
    public function actualizarUsuario(Request $request, UserPasswordHasherInterface $passwordHasher, SluggerInterface $sluggerInterface): JsonResponse
    {

        /** @var Usuario $usuario */
        $usaurioExist = $this->getUser();

        if (!$usaurioExist) {
            return new JsonResponse(['data' => 'Usuario no existe'], JsonResponse::HTTP_CONFLICT);
        }

        $data = json_decode($request->getContent(),true);

        empty($data['nombre']) ? true : $usaurioExist->setNombre($data['nombre']);
        empty($data['apellido1']) ? true : $usaurioExist->setApellido1($data['apellido1']);
        empty($data['apellido2']) ? true : $usaurioExist->setApellido2($data['apellido2']);
        empty($data['email']) ? true : $usaurioExist->setEmail($data['email']);
        empty($data['password']) ? true : $usaurioExist->setPassword($passwordHasher->hashPassword($usaurioExist, $data['password']));
        empty($data['telefono']) ? true : $usaurioExist->setTelefono($data['telefono']);
        empty($data['calle']) ? true : $usaurioExist->setCalle($data['calle']);
        empty($data['numPortal']) ? true : $usaurioExist->setNumPortal($data['numPortal']);
        empty($data['piso']) ? true : $usaurioExist->setPiso($data['piso']);
        empty($data['codigoPostal']) ? true : $usaurioExist->setCodigoPostal($data['codigoPostal']);
        empty($data['ciudad']) ? true : $usaurioExist->setCiudad($data['ciudad']);
        empty($data['pais']) ? true : $usaurioExist->setPais($data['pais']);
        empty($data['provincia']) ? true : $usaurioExist->setProvincia($data['provincia']);
        if (!empty($request->files->get('imagen'))) {
            if (pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION) == 'jpg' || pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION) == 'png' || pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION) == 'jpeg') {
                $nombreFoto = $sluggerInterface->slug(pathinfo($_FILES['imagen']['name'], PATHINFO_FILENAME));
                    $nombreFoto = $nombreFoto . '-' . uniqid() . '.' . pathinfo($_FILES['imagen']['name'], PATHINFO_EXTENSION);
                    try {
                        /** @var UploadedFile $uploadedFile */
                        $uploadedFile = $request->files->get('imagen');

                        $uploadedFile->move(
                            $this->getParameter('userimages_directory'),
                            $nombreFoto
                        );
                        $usaurioExist->setFoto($nombreFoto);
                        
                    } catch (FileException $e) {

                    }
            }
        }
        
        $this->entityManager->flush();

        return new JsonResponse(['data' => 'Usuario Actualizado'], JsonResponse::HTTP_CREATED);
            
    }

    #[Route('/api/usuario/actualizar', name: 'app_usuario_actualizar', methods:['PUT'])]
    public function actualizarUsuarioNoImage(Request $request, UserPasswordHasherInterface $passwordHasher, SluggerInterface $sluggerInterface): JsonResponse
    {

        /** @var Usuario $usuario */
        $usaurioExist = $this->getUser();

        if (!$usaurioExist) {
            return new JsonResponse(['data' => 'Usuario no existe'], JsonResponse::HTTP_CONFLICT);
        }

        $data = json_decode($request->getContent(),true);

        empty($data['nombre']) ? true : $usaurioExist->setNombre($data['nombre']);
        empty($data['apellido1']) ? true : $usaurioExist->setApellido1($data['apellido1']);
        empty($data['apellido2']) ? true : $usaurioExist->setApellido2($data['apellido2']);
        empty($data['email']) ? true : $usaurioExist->setEmail($data['email']);
        empty($data['password']) ? true : $usaurioExist->setPassword($passwordHasher->hashPassword($usaurioExist, $data['password']));
        empty($data['telefono']) ? true : $usaurioExist->setTelefono($data['telefono']);
        empty($data['calle']) ? true : $usaurioExist->setCalle($data['calle']);
        empty($data['numPortal']) ? true : $usaurioExist->setNumPortal($data['numPortal']);
        empty($data['piso']) ? true : $usaurioExist->setPiso($data['piso']);
        empty($data['codigoPostal']) ? true : $usaurioExist->setCodigoPostal($data['codigoPostal']);
        empty($data['ciudad']) ? true : $usaurioExist->setCiudad($data['ciudad']);
        empty($data['pais']) ? true : $usaurioExist->setPais($data['pais']);
        empty($data['provincia']) ? true : $usaurioExist->setProvincia($data['provincia']);
        
        $this->entityManager->flush();

        return new JsonResponse(['data' => 'Usuario Actualizado'], JsonResponse::HTTP_CREATED);
            
    }


    #[Route('/', name: 'app_redirect_to_login')]
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
        $datos['password'] = "";
        $datos['telefono'] = $usuario->getTelefono();
        $datos['calle'] = $usuario->getCalle();
        $datos['numPortal'] = $usuario->getNumPortal();
        $datos['piso'] = $usuario->getPiso();
        $datos['codigoPostal'] = $usuario->getCodigoPostal();
        $datos['ciudad'] = $usuario->getCiudad();
        $datos['pais'] = $usuario->getPais();
        $datos['provincia'] = $usuario->getProvincia();
        $datos['foto'] = $usuario->getFoto();

        
        return $this->convertToJsonResponse($datos);
    }

    #[Route('/api/usuario/validateToken', name: 'app_usuario_id', methods:['GET'])]
    public function isTokenValid(): JsonResponse
    {
        $user = $this->getUser();

        return new JsonResponse(['code' => 401, "message" => 'JWT Token is valid'], JsonResponse::HTTP_OK);
    }

    #[Route('/api/usuario/quitarFoto', name: 'app_usuario_quitar_foto', methods:['DELETE'])]
    public function quitarFoto(): JsonResponse
    {
        /** @var Usuario $usuario */
        $usuario = $this->getUser();
        if ($usuario->getFoto() != null) {
            try {
                unlink($this->getParameter('userimages_directory') . '/' . $usuario->getFoto());
            } catch (\Throwable $th) {
                
            }
        }
        $usuario->setFoto(null);
        $this->entityManager->flush();
        return new JsonResponse(['data' => 'Foto eliminada'], JsonResponse::HTTP_OK);
    }

    #[Route('/api/usuario/ponerFoto', name: 'app_usuario_poner_foto', methods:['POST'])]
    public function ponerFoto(Request $request, SluggerInterface $sluggerInterface): JsonResponse
    {
        /** @var Usuario $usuario */
        $usuario = $this->getUser();
        if ($usuario->getFoto() != null) {
            try {
                unlink($this->getParameter('userimages_directory') . '/' . $usuario->getFoto());
            } catch (\Throwable $th) {
                
            }
        }

        if (pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION) != 'jpg' && pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION) != 'png' && pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION) != 'jpeg' && pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION) != 'webp') 
                {
                    return new JsonResponse(['data' => 'Formato de imagen no valido'], JsonResponse::HTTP_BAD_REQUEST);
                } else
                {
                    $nombreFoto = $sluggerInterface->slug(pathinfo($_FILES['foto']['name'], PATHINFO_FILENAME));
                    $nombreFoto = $nombreFoto . '-' . uniqid() . '.' . pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
                    try {
                        /** @var UploadedFile $uploadedFile */
                        $uploadedFile = $request->files->get('foto');

                        $uploadedFile->move(
                            $this->getParameter('userimages_directory'),
                            $nombreFoto
                        );
                        $usuario->setFoto($nombreFoto);
                        
                    } catch (FileException $e) {
                        return new JsonResponse(['data' => 'Error al subir la imagen'], JsonResponse::HTTP_BAD_REQUEST);
                    }
        $this->entityManager->flush();
        return new JsonResponse(['data' => 'Foto Subida', 'nombre' => $nombreFoto], JsonResponse::HTTP_OK);
    }
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
