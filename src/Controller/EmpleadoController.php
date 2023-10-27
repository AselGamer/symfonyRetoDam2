<?php

namespace App\Controller;


use App\Entity\Empleado;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmpleadoController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/empleado', name: 'app_empleado')]
    public function index(): Response
    {
        session_start();

        if (!isset($_SESSION['id_empleado'])) {
            return $this->redirect('login');
        }
        
        return $this->render('usuario/index.html.twig', [
            'controller_name' => 'EmpleadoController',
        ]);
    }


    #[Route('/login', name: 'app_empleado_login', methods:['GET','POST'])]
    public function login(Request $request): Response
    {
        
        if ($_SERVER['REQUEST_METHOD']=='POST'){
            $empleado = $this->entityManager->getRepository(Empleado::class)->findOneBy(['email' => $_POST['username'], 'password' => $_POST['password']]);
            if ($empleado != null) {
                session_start();
                $_SESSION['username'] = $empleado->getEmail();
                $_SESSION['id_empleado'] = $empleado->getIdempleado();
                return $this->redirect('empleado');
            }
            
        }

        return $this->render('auth/login.html.twig', [
            'controller_name' => 'UsuarioController',
        ]);
    }


    #[Route('/register', name: 'app_empleado_register', methods:['GET','POST'])]
    public function register(Request $request): Response
    {

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $existingEmpleado = $this->entityManager->getRepository(Empleado::class)->findOneBy(['email' => $_POST['email']]);
            if ($existingEmpleado !== null) {
                return $this->render('auth/register.html.twig', [
                    'error' => "Error: El usuario ya existe"
                ]);
            } else {
                $error = false;
                empty($_POST['nombre']) ? $error = true : $nombre = $_POST['nombre'];
                empty($_POST['apellido1']) ? $error = true : $apellido = $_POST['apellido1'];
                empty($_POST['apellido2']) ? $error = true : $apellido2 = $_POST['apellido2'];
                empty($_POST['email']) ? $error = true : $email = $_POST['email'];
                empty($_POST['password']) ? $error = true : $password = $_POST['password'];
                $gerente = filter_var($_POST['gerente'], FILTER_VALIDATE_BOOLEAN);

                var_dump($_POST['gerente']);

                if ($error) {
                    return $this->render('auth/register.html.twig', [
                        'error' => "Error: Debes rellenar todos los campos"
                    ]);
                } else {
                    $empleado = new Empleado();
                    $empleado->setNombre($nombre);
                    $empleado->setApellido1($apellido);
                    $empleado->setApellido2($apellido2);
                    $empleado->setEmail($email);
                    $empleado->setPassword($password);
                    $empleado->setGerente($gerente);
                    $this->entityManager->persist($empleado);
                    $this->entityManager->flush();
                    return $this->redirect('login');
                }
            }
        }


        return $this->render('auth/register.html.twig', [
            'error' => null
        ]);
    }
}
